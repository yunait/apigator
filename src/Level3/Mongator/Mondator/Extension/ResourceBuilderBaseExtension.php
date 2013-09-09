<?php

namespace Level3\Mongator\Mondator\Extension;

use Mandango\Mondator\Definition\Constant;
use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;

class ResourceBuilderBaseExtension extends Extension
{
    const CLASSES_NAMESPACE = 'Resources\\Base\\Builder';
    const CLASSES_PREFIX = '';
    const CLASSES_SUFFIX = 'ResourceBuilder';

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
        $targetClassName = $this->getTargetClass('');
        $definition = $this->definitionFactory->create($targetClassName, $output);

        $this->definitions['baseBuilder'] = $definition;
        $definition->setAbstract(true);
        $this->addFieldsToDefinition($definition);
        $this->addMethodsToDefinition($definition);
    }

    private function addFieldsToDefinition(Definition $definition)
    {
        $definition->addProperty(new Property('private', 'document', null));
        $definition->addProperty(new Property('private', 'builder', null));
        $definition->addProperty(new Property('protected', 'allowedKeys', null));
    }

    private function addMethodsToDefinition(Definition $definition)
    {
        $this->addConstructorToDefinition($definition);
        $this->addBuildToDefinition($definition);
        $this->addGetBuilderToDefinition($definition);
        $this->addGetDocumentToDefinition($definition);
        $this->addExtractBasicInfoToDefinition($definition);
        $this->addSetDataToDefinition($definition);
        $this->addSetLinksToDefinition($definition);
    }

    private function addConstructorToDefinition(Definition $definition)
    {
        $method = new Method(
            'public',
            '__construct',
            '\Level3\Hal\ResourceBuilder $builder, $document',
<<<EOF
        \$this->document = \$document;
        \$this->builder = \$builder;
EOF
        );

        $definition->addMethod($method);
    }

    private function addBuildToDefinition(Definition $definition)
    {
        $method = new Method(
            'public',
            'build',
            null,
<<<EOF
        \$this->setData();
        \$this->setLinks();

        return \$this->builder->build();
EOF
        );

        $definition->addMethod($method);
    }

    private function addGetBuilderToDefinition(Definition $definition)
    {
        $method = new Method(
            'public',
            'getBuilder',
            null,
<<<EOF
        return \$this->builder;
EOF
        );

        $definition->addMethod($method);
    }

    private function addGetDocumentToDefinition(Definition $definition)
    {
        $method = new Method(
            'public',
            'getDocument',
            null,
<<<EOF
        return \$this->document;
EOF
        );

        $definition->addMethod($method);
    }

    private function addExtractBasicInfoToDefinition(Definition $definition)
    {
        $method = new Method(
            'protected',
            'extractBasicInfo',
            null,
<<<EOF
        \$documentArray = \$this->document->toArray();
        \$data = array('id' => \$documentArray['id']);
        foreach (\$documentArray as \$key => \$value) {
            if (in_array(\$key, \$this->allowedKeys)) {
                \$data[\$key] = \$value;
            }
        }

        return \$data;
EOF
        );

        $definition->addMethod($method);
    }

    private function addSetDataToDefinition(Definition $definition)
    {
        $method = new Method('protected', 'setData', null, null);
        $method->setAbstract(true);
        $definition->addMethod($method);
    }


    private function addSetLinksToDefinition(Definition $definition)
    {
        $method = new Method('protected', 'setLinks', null, null);
        $method->setAbstract(true);
        $definition->addMethod($method);
    }
}