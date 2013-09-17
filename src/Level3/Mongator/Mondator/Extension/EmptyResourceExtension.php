<?php

namespace Level3\Mongator\Mondator\Extension;

use Mandango\Mondator\Definition\Constant;
use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;

class EmptyResourceExtension extends Extension
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
        $this->definitions['emptyResource'] = $this->definition;
        $this->definition->setParentClass($this->getParentClass($this->getClassName()));
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