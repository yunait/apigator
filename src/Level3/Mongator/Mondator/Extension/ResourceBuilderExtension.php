<?php

namespace Level3\Mongator\Mondator\Extension;

use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;

class ResourceBuilderExtension extends Extension
{
    const CLASSES_NAMESPACE = 'Resources\\Base\\Builder';
    const CLASSES_PREFIX = '';
    const CLASSES_SUFFIX = 'Builder';

    public function __construct($options = array())
    {
        parent::__construct($options);

        $this->classesNamespace = self::CLASSES_NAMESPACE;
        $this->classesPrefix = self::CLASSES_PREFIX;
        $this->classesSuffix = self::CLASSES_SUFFIX;
    }

    protected function generateClass()
    {
        $output = $this->outputFactory->create($this->getOption('output'), true);
        $targetClassName = $this->getTargetClass($this->getClassName());
        $definition = $this->definitionFactory->create($targetClassName, $output);
        $this->definitions['resourceBuilder'] = $definition;
        $definition->setAbstract(true);
        $definition->setParentClass($this->getParentClass());
        $this->addMethodsToDefinition($definition);
    }

    private function getParentClass()
    {
        return '\\' . $this->getOption('namespace') .
        '\\' .
        ResourceBuilderBaseExtension::CLASSES_NAMESPACE .
        '\\' .
        ResourceBuilderBaseExtension::CLASSES_PREFIX .
        ResourceBuilderBaseExtension::CLASSES_SUFFIX;
    }

    private function addMethodsToDefinition(Definition $definition)
    {
        $this->addConstructorToDefinition($definition);
        $this->addInitAllowedKeysToDefinition($definition);
        $this->addSetDataToDefinition($definition);
        $this->addSetLinksToDefinition($definition);
        $this->addMethodsForEmbeddedDocumentsToDefinition($definition);
    }

    private function addConstructorToDefinition(Definition $definition)
    {
        $method = new Method(
            'public',
            '__construct',
            '\Level3\Hal\ResourceBuilder $builder, $document',
<<<EOF
        parent::__construct(\$builder, \$document);
        \$this->initAllowedKeys();
EOF
        );

        $definition->addMethod($method);
    }

    private function addInitAllowedKeysToDefinition(Definition $definition)
    {
        $code =
<<<EOF
        \$this->allowedKeys = array (\n
EOF;

        foreach ($this->configClass['fields'] as $fieldName => $fieldConfig) {
            if (!isset($fieldConfig['hideFromApi']) || !$fieldConfig['hideFromApi']) {
                $code = $code . '            \'' . $fieldName . "',\n";
            }
        }


        $code = $code .
<<<EOF
        );
EOF;
        $method = new Method(
            'private',
            'initAllowedKeys',
            null,
            $code
        );

        $definition->addMethod($method);
    }

    private function addSetDataToDefinition(Definition $definition)
    {
        $code =
<<<EOF
        \$data = \$this->extractBasicInfo();
        \$data['id'] = (string) \$data['id'];
EOF;
        $embeddeds = array_merge($this->getEmbeddedOne(), $this->getEmbeddedMany());
        foreach ($embeddeds as $embedded) {
            $code = $code . sprintf("\n        \$data['$embedded'] = \$this->extract%s();", ucfirst($embedded));
        }

        $code = $code . "\n\n        \$this->getBuilder()->withData(\$data);";

        $method = new Method(
            'protected',
            'setData',
            null,
            $code
        );

        $definition->addMethod($method);
    }

    private function addSetLinksToDefinition(Definition $definition)
    {
        $code = '';

        if (isset($this->configClass['referencesOne'])) {
            foreach ($this->configClass['referencesOne'] as $key => $value) {
                $class = $value['class'];
                $referencedResourceName = $this->getResourceKey($class);

                $code = $code . $this->generateRelationsToOneLinksLoopBody($key, $referencedResourceName);
            }
        }

        if (isset($this->configClass['referencesMany'])){
            foreach ($this->configClass['referencesMany'] as $key => $value) {
                $referencedResourceName = $this->getResourceKey($value['class']);

                $code = $code . $this->generateRelationsToManyLinksLoopBody($key, $referencedResourceName);
            }
        }

        $method = new Method(
            'protected',
            'setLinks',
            null,
            $code
        );

        $definition->addMethod($method);
    }

    private function getResourceKey($class)
    {
        return strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $this->getClassName($class)));
    }

    private function generateRelationsToOneLinksLoopBody($key, $referencedResourceName)
    {

        $code =
<<<EOF
        \$referenced = \$this->getDocument()->get%s();
        if (\$referenced) {
            \$this->getBuilder()->withLinkToResource('%s',
                '%s', new \Level3\Messages\Parameters(['id' => \$referenced->getId()]), (string) \$referenced->getId()
            );
        }\n
EOF;

        return sprintf($code, ucfirst($key), $key, $referencedResourceName);
    }

    private function generateRelationsToManyLinksLoopBody($key, $collectionName)
    {

        $code =
<<<EOF
        foreach (\$this->getDocument()->get%s() as \$relation) {
            \$this->getBuilder()->withLinkToResource('%s',
                '%s', new \Level3\Messages\Parameters(['id' => \$relation->getId()]), (string) \$relation->getId()
            );
        }\n
EOF;

        return sprintf($code, ucfirst($key), $key, $collectionName);
    }

    private function addMethodsForEmbeddedDocumentsToDefinition(Definition $definition)
    {
        foreach ($this->getEmbeddedOne() as $embedded) {
            $this->addMethodForEmbeddedOneDocumentToDefinition($definition, $embedded);
        }

        foreach ($this->getEmbeddedMany() as $embedded) {
                $this->addMethodForEmbeddedManyDocumentsToDefinition($definition, $embedded);
        }
    }

    private function getEmbeddedOne()
    {
        if (isset($this->configClass['embeddedsOne'])) {
            return array_keys($this->configClass['embeddedsOne']);
        }

        return array();
    }

    private function getEmbeddedMany()
    {
        if (isset($this->configClass['embeddedsMany'])) {
            return array_keys($this->configClass['embeddedsMany']);
        }

        return array();
    }

    private function addMethodForEmbeddedOneDocumentToDefinition(Definition $definition, $embedded)
    {
        $code =
<<<EOF
        \$%s = \$this->getDocument()->get%s();
        if (!\$%s) return null;
        return $%s->toArray();
EOF;
        $code = sprintf($code, $embedded, ucfirst($embedded), $embedded, $embedded);

        $method = new Method('protected', sprintf('extract%s', ucfirst($embedded)), null, $code);
        $definition->addMethod($method);
    }

    private function addMethodForEmbeddedManyDocumentsToDefinition(Definition $definition, $embedded)
    {
        $code =
<<<EOF
        \$%s = [];
        foreach(\$this->getDocument()->get%s() as \$elem) \$%s[] = \$elem->toArray();

        return \$%s;
EOF;
        $code = sprintf($code, $embedded, ucfirst($embedded), $embedded, $embedded);

        $method = new Method('protected', sprintf('extract%s', ucfirst($embedded)), null, $code);
        $definition->addMethod($method);
    }
}