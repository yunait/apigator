<?php

namespace Level3\Mongator\Mondator\Extension;

use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;

class ResourceExtension extends Extension
{
    const CLASSES_NAMESPACE = 'Resources\\Base';
    const CLASSES_PREFIX = '';
    const CLASSES_SUFFIX = '';

    public function __construct($options = array())
    {
        parent::__construct($options);

        $this->classesNamespace = self::CLASSES_NAMESPACE;
        $this->classesPrefix = self::CLASSES_PREFIX;
        $this->classesSuffix = self::CLASSES_SUFFIX;
    }

    protected function generateClass()
    {
        $this->definitions['emptyResourceBuilder'] = $this->definition;

        $this->setParentClass($this->definition);
        $this->addGetDocumentAsResourceToDefinition($this->definition);
        $this->addParseCriteriaTypesMethodToDefinition($this->definition);
        $this->addPersistsDocumentoDefinition($this->definition);
    }

    private function setParentClass(Definition $definition)
    {
        if ($this->configClass['isEmbedded']) {
            $definition->setParentClass('\Level3\Mongator\Resources\EmbeddedResource');
        } else {
            $definition->setParentClass('\Level3\Mongator\Resources\Resource');
        }
    }

    private function addGetDocumentAsResourceToDefinition(Definition $definition)
    {
        $formaterClass = '\\' . $this->getOption('namespace') . '\\' .
            EmptyResourceFormatterExtension::CLASSES_NAMESPACE . '\\' .
            EmptyResourceFormatterExtension::CLASSES_PREFIX .
            $this->getClassName() .
            EmptyResourceFormatterExtension::CLASSES_SUFFIX;

        $method = new Method('protected', 'getDocumentAsResource', '\Mongator\Document\AbstractDocument $document',
<<<EOF
        \$formatter = new $formaterClass();
        return \$formatter->toResponse(\$this->createResourceBuilder(), \$document);
EOF
        );

        $definition->addMethod($method);
    }

    private function addPersistsDocumentoDefinition(Definition $definition)
    {
        $formaterClass = '\\' . $this->getOption('namespace') . '\\' .
            EmptyResourceFormatterExtension::CLASSES_NAMESPACE . '\\' .
            EmptyResourceFormatterExtension::CLASSES_PREFIX .
            $this->getClassName() .
            EmptyResourceFormatterExtension::CLASSES_SUFFIX;

        $method = new Method('protected', 'persistsDocument', '\Mongator\Document\AbstractDocument $document, Array $data',
<<<EOF
        \$formatter = new $formaterClass();
        \$data = \$formatter->fromRequest(\$data);
        return parent::persistsDocument(\$document, \$data);
EOF
        );

        $definition->addMethod($method);
    }



    protected function persistsDocument(AbstractDocument $document, Array $data)
    {
        $document->fromArray($data);
        $document->save();
    }

    private function addParseCriteriaTypesMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $code = '';
        foreach($this->configClass['fields'] as $field => $fieldConfig) {

            if ($fieldConfig['type'] === 'string') {
                $code = $code . "        if (isset(\$criteria['$field'])) \$criteria['$field'] = (string) urldecode(\$criteria['$field']);\n";
            }
            if ($fieldConfig['type'] === 'integer') {
                $code = $code . "        if (isset(\$criteria['$field'])) \$criteria['$field'] = (int) \$criteria['$field'];\n";
            }
        }
        $code = $code . "        return \$criteria;";

        $method = new Method('protected', 'parseCriteriaTypes', 'array $criteria', $code);

        $definition->addMethod($method);
    }

    private function addFilterCriteriaMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $code = "        \$result = [];\n";
        foreach($this->configClass['fields'] as $field => $fieldConfig) {
            if (!isset($fieldConfig['findByMethod'])) {
                continue;
            }

            $findByMethod = $fieldConfig['findByMethod'];

            if ($fieldConfig['type'] === 'string') {
                $code = $code . "        if (isset(\$criteria['$field'])) \$result['$findByMethod'] = (string) urldecode(\$criteria['$field']);\n";
            }
            if ($fieldConfig['type'] === 'integer') {
                $code = $code . "        if (isset(\$criteria['$field'])) \$result['$findByMethod'] = (int) \$criteria['$field'];\n";
            }
        }
        $code = $code . "        return \$result;";

        print_r($this->configClasses);die;

        $method = new Method('protected', 'filterCriteria', 'array $criteria', $code);

        $definition->addMethod($method);
    }
}
