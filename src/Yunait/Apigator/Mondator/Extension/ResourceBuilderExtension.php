<?php

namespace Yunait\Apigator\Mondator\Extension;

use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;
use Mandango\Mondator\Extension;
use Yunait\Apigator\Mondator\Definition\DefinitionFactory;
use Yunait\Apigator\Mondator\OutputFactory;

class ResourceBuilderExtension extends ApigatorExtension
{
    const CLASSES_NAMESPACE = 'Resources\\Builder';
    const CLASSES_PREFIX = '';
    const CLASSES_SUFFIX = '';

    private $outputFactory;
    private $definitionFactory;
    private $repositoryNamePrefix;

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->setOutputFactory($this->getOption('outputFactory'));
        $this->setDefinitionFactory($this->getOption('definitionFactory'));
        $this->setRepositoryNamePrefix($this->getOption('repositoryNamePrefix'));
    }

    private function setOutputFactory(OutputFactory $outputFactory)
    {
        $this->outputFactory = $outputFactory;
    }

    private function setDefinitionFactory(DefinitionFactory $definitionFactory){
        $this->definitionFactory = $definitionFactory;
    }

    private function setRepositoryNamePrefix($repositoryNamePrefix)
    {
        $this->repositoryNamePrefix = $repositoryNamePrefix;
    }

    protected function setup()
    {
        $this->addRequiredOption('output');
        $this->addRequiredOption('namespace');
        $this->addRequiredOption('outputFactory');
        $this->addRequiredOption('definitionFactory');
        $this->addRequiredOption('repositoryNamePrefix');
    }

    protected function doClassProcess()
    {
        if ($this->configClass['isEmbedded']) {
            return;
        }

        $this->generateClass();
    }

    private function generateClass()
    {
        $output = $this->outputFactory->create($this->getOption('output'), true);
        print_r($this->configClass);
        $targetClassName = $this->getTargetClassForClassname($this->getClassName());
        $definition = $this->definitionFactory->create($targetClassName, $output);

        $this->definitions['resource'] = $definition;
        $definition->AddInterface('\Level3\Repository\Finder');
        $definition->addInterface('\Level3\Repository\Getter');
        $definition->setParentClass('Base');
        $this->addAttributesToDefinition($definition);
        $this->addFindMethodToDefinition($definition);
        $this->addGetMethodToDefinition($definition);
        $this->addGetDocumentAsResource($definition);

    }

    private function addAttributesToDefinition(Definition $definition)
    {
        $property = new Property('protected', 'documentRepository', $this->repositoryNamePrefix . $this->configClass['collection']);
        $definition->addProperty($property);
    }

    private function addFindMethodToDefinition(Definition $definition)
    {
        $method = new Method('public', 'find', '$lowerBound = 0, $upperBound = 0',
<<<EOF
        \$builder = \$this->createResourceBuilder();
        foreach (\$this->retrieveCategoriesFromDatabase() as \$id => \$partner) {
            \$builder->withEmbedded('categories', \$this->getKey(), \$id);
        }

        return \$builder->build();
EOF
        );
        $definition->addMethod($method);
    }

    private function addGetMethodToDefinition(Definition $definition)
    {
        $method = new Method('public', 'get', '$id',
<<<EOF
        \$document = \$this->getDocument(\$id);

        return \$this->getDocumentAsResource(\$document);
EOF
        );
        $definition->addMethod($method);
    }

    private function addGetDocumentAsResource(Definition $definition)
    {
        $method = new Method('private', 'getDocumentAsResource', '\\' . $this->class .' $id',
<<<EOF
        \$document = \$this->getDocument(\$id);

        return \$this->getDocumentAsResource(\$document);
EOF
        );
        $definition->addMethod($method);
    }

    private function getTargetClassForClassname($className)
    {
        return $this->getOption('namespace') .
        '\\' .
        self::CLASSES_NAMESPACE .
        '\\' .
        self::CLASSES_PREFIX .
        $className .
        self::CLASSES_SUFFIX;

    }

    private function getClassName()
    {
        $lastBackslashPosition = $this->getLastBackslashPosition();
        return substr($this->class, $lastBackslashPosition + 1);
    }

    private function getLastBackslashPosition()
    {
        return strrpos($this->class, '\\');
    }
}