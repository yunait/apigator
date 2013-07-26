<?php

namespace Yunait\Apigator\Mondator\Extension;

use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;
use Mandango\Mondator\Extension;

class ResourceExtension extends ApigatorExtension
{
    const CLASSES_NAMESPACE = 'Resources\\Base';
    const CLASSES_PREFIX = '';
    const CLASSES_SUFFIX = '';
    private $repositoryNamePrefix;

    public function __construct($options = array())
    {
        parent::__construct($options);

        $this->classesNamespace = self::CLASSES_NAMESPACE;
        $this->classesPrefix = self::CLASSES_PREFIX;
        $this->classesSuffix = self::CLASSES_SUFFIX;
        $this->setRepositoryNamePrefix($this->getOption('repositoryNamePrefix'));
    }

    private function setRepositoryNamePrefix($repositoryNamePrefix)
    {
        $this->repositoryNamePrefix = $repositoryNamePrefix;
    }

    protected function setup()
    {
        parent::setup();
        $this->addRequiredOption('repositoryNamePrefix');
    }

    protected function generateClass()
    {
        $output = $this->outputFactory->create($this->getOption('output'), true);
        print_r($this->configClass);
        $targetClassName = $this->getTargetClassForClassname($this->getClassName());
        $definition = $this->definitionFactory->create($targetClassName, $output);

        $this->definitions['resource'] = $definition;
        $definition->setAbstract(true);
        $definition->AddInterface('\Level3\Repository\Finder');
        $definition->addInterface('\Level3\Repository\Getter');
        $definition->setParentClass('Base');
        $this->addAttributesToDefinition($definition);
        $this->addFindMethodToDefinition($definition);
        $this->addGetMethodToDefinition($definition);
        $this->addGetDocumentAsResource($definition);
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
        $method = new Method('private', 'getDocumentAsResource', '\\' . $this->class . ' $id',
<<<EOF
        \$document = \$this->getDocument(\$id);

        return \$this->getDocumentAsResource(\$document);
EOF
        );
        $definition->addMethod($method);
    }
}