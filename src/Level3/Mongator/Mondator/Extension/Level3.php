<?php

namespace Level3\Mongator\Mondator\Extension;

use Mandango\Mondator\Extension as BaseExtension;

use Mandango\Mondator\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;
use Mandango\Mondator\Output;
use Mongator\Twig\Mongator as MongatorTwig;

class Level3 extends BaseExtension
{
    const NAMESPACE_SEPARARTOR = '\\';

    protected $output;

    protected $outputFactory;
    protected $definitionFactory;

    //To be overriden by subclasses
    protected $classesNamespace;
    protected $classesPrefix;
    protected $classesSuffix;

    protected function createOutput()
    {
        $dir = $this->getOption('default_output');
        if (isset($this->configClass['output'])) {
            $dir = $this->configClass['output'];
        }

        $this->output = new Output($dir);
        $this->outputOverride = new Output($dir, true);

    }

    protected function setup()
    {
        $this->addRequiredOption('default_output');
        $this->addRequiredOption('namespace');
        $this->addRequiredOption('models_namespace');
    }

    protected function doClassProcess()
    {
        if (!$this->isCandidate()) {
            return;
        }
        
        $this->createOutput();

        $this->parseAndCheckFieldsProcess();
        $this->parseAndCheckReferencesProcess();
        $this->parseAndCheckEmbeddedsProcess();
        if (!$this->configClass['isEmbedded']) {
            $this->parseAndCheckRelationsProcess();
        }

        $this->checkDataNamesProcess();
        $this->initDefinitionsProcess();
    }

    private function createDefinition($class, $parent, $override = false, $template = false)
    {
        if ($override) $output = $this->outputOverride;
        else $output = $this->output;

        $definition = new Definition($class, $output);
        $definition->setParentClass('\\'.$parent);
        $definition->setDocComment(<<<EOF
/**
 * {$class} document.
 */
EOF
        );

        if ($template) {
            $twig = file_get_contents(__DIR__.'/templates/'.$template.'.php.twig');
            $this->processTemplate($definition, $twig);
        }
        
        return $definition;
    }


    public function getModelClassName($class = null)
    {
        if (!$class) {
            $class = $this->class;
        }

        $model = str_replace($this->getOption('models_namespace'), '', $class);

        return $this->getOption('namespace') . self::NAMESPACE_SEPARARTOR . $model;
    }

    public function getBaseModelClassName($class = null)
    {
        if (!$class) {
            $class = $this->class;
        }

        $model = str_replace($this->getOption('models_namespace'), '', $class);

        return $this->getOption('namespace') . self::NAMESPACE_SEPARARTOR . 'Base' . self::NAMESPACE_SEPARARTOR . $model ;
    }

    private function initDefinitionsProcess()
    {

        $classes = array();
        $classes['resource'] = $this->getModelClassName() . 'Resource';
        $classes['resource_base'] = $this->getBaseModelClassName() . 'Resource';
        $classes['repository'] = $this->getModelClassName() . 'Repository';
        $classes['repository_base'] = $this->getBaseModelClassName() . 'Repository';

        $this->configClass['classes'] = $classes;

        $this->definitions['resource'] = $this->createDefinition(
            $classes['resource'], $classes['resource_base']
        );

        $this->definitions['resource_base'] = $this->createDefinition(
            $classes['resource_base'], 'Level3\Resource',
            true, 'Resource'
        );

        $this->definitions['repository'] = $this->createDefinition(
            $classes['repository'], $classes['repository_base']
        );

        $this->definitions['repository_base'] = $this->createDefinition(
            $classes['repository_base'], 'Level3\Repository',
            true, 'Repository'
        );

        $this->definitions['repository_base']->setInterfaces(array(
            '\Level3\Repository\Getter', 
            '\Level3\Repository\Finder', 
            '\Level3\Repository\Putter', 
            '\Level3\Repository\Poster',
            '\Level3\Repository\Patcher', 
            '\Level3\Repository\Deleter'
        ));
    }


    protected function isCandidate()
    {
        if (!isset($this->configClass['isEmbedded'])) {
            return true;
        }

        if (!$this->configClass['isEmbedded']) {
            return true;
        }

        if (isset($this->configClass['fields']['id'])) {
            return true;
        }
        
        return false;
    }

    protected function getTargetClass($className)
    {
        return $this->getOption('namespace') .
        '\\' .
        $this->classesNamespace .
        '\\' .
        $this->classesPrefix .
        $className .
        $this->classesSuffix;
    }

    protected function getClassName($className = null)
    {
        if (!$className) {
            $className = $this->class;
        }

        return str_replace($this->getOption('models_namespace'), '', $className);
    }

    protected function getLastBackslashPosition($className)
    {
        return strrpos($className, '\\');
    }

    private function parseAndCheckFieldsProcess()
    {
        foreach ($this->configClass['fields'] as $name => &$field) {
            if (is_string($field)) {
                $field = array('type' => $field);
            }
        }
        unset($field);

        foreach ($this->configClass['fields'] as $name => &$field) {
            if (!is_array($field)) {
                throw new \RuntimeException(sprintf('The field "%s" of the class "%s" is not a string or array.', $name, $this->class));
            }

            if (!isset($field['type'])) {
                throw new \RuntimeException(sprintf('The field "%s" of the class "%s" does not have type.', $name, $this->class));
            }

            if (!isset($field['dbName'])) {
                $field['dbName'] = $name;
            } elseif (!is_string($field['dbName'])) {
                throw new \RuntimeException(sprintf('The dbName of the field "%s" of the class "%s" is not an string.', $name, $this->class));
            }
        }
        unset($field);
    }

    private function parseAndCheckReferencesProcess()
    {
        // one
        foreach ($this->configClass['referencesOne'] as $name => &$reference) {
            $this->parseAndCheckAssociationClass($reference, $name);

            if ($this->configClass['inheritance'] && !isset($reference['inherited'])) {
                $reference['inherited'] = false;
            }

            if (!isset($reference['field'])) {
                $reference['field'] = $name.'_reference_field';
            }
            $field = array('type' => 'raw', 'dbName' => $name, 'referenceField' => true);
            if (!empty($reference['inherited'])) {
                $field['inherited'] = true;
            }
            $this->configClass['fields'][$reference['field']] = $field;
        }

        // many
        foreach ($this->configClass['referencesMany'] as $name => &$reference) {
            $this->parseAndCheckAssociationClass($reference, $name);

            if ($this->configClass['inheritance'] && !isset($reference['inherited'])) {
                $reference['inherited'] = false;
            }

            if (!isset($reference['field'])) {
                $reference['field'] = $name.'_reference_field';
            }
            $field = array('type' => 'raw', 'dbName' => $name, 'referenceField' => true);
            if (!empty($reference['inherited'])) {
                $field['inherited'] = true;
            }
            $this->configClass['fields'][$reference['field']] = $field;
        }
    }

    private function parseAndCheckEmbeddedsProcess()
    {
        // one
        foreach ($this->configClass['embeddedsOne'] as $name => &$embedded) {
            $this->parseAndCheckAssociationClass($embedded, $name);

            if ($this->configClass['inheritance'] && !isset($embedded['inherited'])) {
                $embedded['inherited'] = false;
            }
        }

        // many
        foreach ($this->configClass['embeddedsMany'] as $name => &$embedded) {
            $this->parseAndCheckAssociationClass($embedded, $name);

            if ($this->configClass['inheritance'] && !isset($embedded['inherited'])) {
                $embedded['inherited'] = false;
            }
        }
    }

    private function parseAndCheckRelationsProcess()
    {
        // one
        foreach ($this->configClass['relationsOne'] as $name => &$relation) {
            $this->parseAndCheckAssociationClass($relation, $name);

            if (!isset($relation['reference'])) {
                throw new \RuntimeException(sprintf('The relation one "%s" of the class "%s" does not have reference.', $name, $this->class));
            }
        }

        // many_one
        foreach ($this->configClass['relationsManyOne'] as $name => &$relation) {
            $this->parseAndCheckAssociationClass($relation, $name);

            if (!isset($relation['reference'])) {
                throw new \RuntimeException(sprintf('The relation many one "%s" of the class "%s" does not have reference.', $name, $this->class));
            }
        }

        // many_many
        foreach ($this->configClass['relationsManyMany'] as $name => &$relation) {
            $this->parseAndCheckAssociationClass($relation, $name);

            if (!isset($relation['reference'])) {
                throw new \RuntimeException(sprintf('The relation many many "%s" of the class "%s" does not have reference.', $name, $this->class));
            }
        }

        // many_through
        foreach ($this->configClass['relationsManyThrough'] as $name => &$relation) {
            if (!is_array($relation)) {
                throw new \RuntimeException(sprintf('The relation_many_through "%s" of the class "%s" is not an array.', $name, $this->class));
            }
            if (!isset($relation['class'])) {
                throw new \RuntimeException(sprintf('The relation_many_through "%s" of the class "%s" does not have class.', $name, $this->class));
            }
            if (!isset($relation['through'])) {
                throw new \RuntimeException(sprintf('The relation_many_through "%s" of the class "%s" does not have through.', $name, $this->class));
            }

            if (!isset($relation['local'])) {
                throw new \RuntimeException(sprintf('The relation_many_through "%s" of the class "%s" does not have local.', $name, $this->class));
            }
            if (!isset($relation['foreign'])) {
                throw new \RuntimeException(sprintf('The relation_many_through "%s" of the class "%s" does not have foreign.', $name, $this->class));
            }
        }
    }

    private function checkDataNamesProcess()
    {
        foreach (array_merge(
            array_keys($this->configClass['fields']),
            array_keys($this->configClass['referencesOne']),
            array_keys($this->configClass['referencesMany']),
            array_keys($this->configClass['embeddedsOne']),
            array_keys($this->configClass['embeddedsMany']),
            !$this->configClass['isEmbedded'] ? array_keys($this->configClass['relationsOne']) : array(),
            !$this->configClass['isEmbedded'] ? array_keys($this->configClass['relationsManyOne']) : array(),
            !$this->configClass['isEmbedded'] ? array_keys($this->configClass['relationsManyMany']) : array(),
            !$this->configClass['isEmbedded'] ? array_keys($this->configClass['relationsManyThrough']) : array()
        ) as $name) {
            if (in_array($name, array('Mongator', 'repository', 'collection', 'query_for_save', 'fields_modified', 'document_data'))) {
                throw new \RuntimeException(sprintf('The document or embeddedDocument cannot be a data with the name "%s".', $name));
            }

            if (!$this->configClass['isEmbedded'] && $name == 'id') {
                throw new \RuntimeException(sprintf('The document cannot be a data with the name "%s".', $name));
            }
        }
    }

    private function parseAndCheckAssociationClass(&$association, $name)
    {
        if (!is_array($association)) {
            throw new \RuntimeException(sprintf('The association "%s" of the class "%s" is not an array or string.', $name, $this->class));
        }

        if (!empty($association['class'])) {
            if (!is_string($association['class'])) {
                throw new \RuntimeException(sprintf('The class of the association "%s" of the class "%s" is not an string.', $name, $this->class));
            }
        } elseif (!empty($association['polymorphic'])) {
            if (empty($association['discriminatorField'])) {
                $association['discriminatorField'] = '_MongatorDocumentClass';
            }
            if (empty($association['discriminatorMap'])) {
                $association['discriminatorMap'] = false;
            }
        } else {
            throw new \RuntimeException(sprintf('The association "%s" of the class "%s" does not have class and it is not polymorphic.', $name, $this->class));
        }
    }

    protected function configureTwig(\Twig_Environment $twig)
    {
        $twig->addExtension(new MongatorTwig());
    }
}