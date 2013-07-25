<?php

namespace Yunait\Apigator\Mondator\Extension;

use Mandango\Mondator\Definition\Constant;
use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;
use Mandango\Mondator\Extension;

class ResourceBuilderBaseExtension extends ApigatorExtension
{
    const CLASSES_NAMESPACE = 'Resources\\Base\\Builder';
    const CLASSES_PREFIX = 'Base';
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
        $this->addGetAppToDefinition($definition);
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
            '\Silex\Application $app, \Level3\Hal\ResourceBuilder $builder, $document',
<<<EOF
        \$this->app = \$app;
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

    private function addGetAppToDefinition(Definition $definition)
    {
        $method = new Method(
            'public',
            'getApp',
            null,
<<<EOF
        return \$this->app;
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
        \$data = array();
        foreach (\$this->document->toArray() as \$key => \$value) {
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