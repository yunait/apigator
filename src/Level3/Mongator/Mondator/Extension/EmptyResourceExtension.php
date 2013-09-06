<?php

namespace Level3\Mongator\Mondator\Extension;

use Mandango\Mondator\Definition\Constant;
use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;
use Mandango\Mondator\Extension;

class EmptyResourceExtension extends ApigatorExtension
{
    const CLASSES_NAMESPACE = 'Resources';
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
        $output = $this->outputFactory->create($this->getOption('output'), false);
        $targetClassName = $this->getTargetClass($this->getClassName());
        $definition = $this->definitionFactory->create($targetClassName, $output);

        $this->definitions['emptyResource'] = $definition;
        $definition->setParentClass($this->getParentClass($this->getClassName()));
    }

    private function getParentClass($class)
    {
        return '\\' . $this->getOption('namespace') .
        '\\' .
        ResourceExtension::CLASSES_NAMESPACE .
        '\\' .
        ResourceExtension::CLASSES_PREFIX .
        $class;
    }
}