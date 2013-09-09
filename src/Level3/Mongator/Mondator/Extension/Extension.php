<?php

namespace Level3\Mongator\Mondator\Extension;

use Mandango\Mondator\Extension as BaseExtension;
use Level3\Mongator\Mondator\Definition\DefinitionFactory;
use Level3\Mongator\Mondator\OutputFactory;

abstract class Extension extends BaseExtension
{
    protected $outputFactory;
    protected $definitionFactory;

    //To be overriden by subclasses
    protected $classesNamespace;
    protected $classesPrefix;
    protected $classesSuffix;

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->setOutputFactory($this->getOption('outputFactory'));
        $this->setDefinitionFactory($this->getOption('definitionFactory'));
    }

    private function setOutputFactory(OutputFactory $outputFactory)
    {
        $this->outputFactory = $outputFactory;
    }

    private function setDefinitionFactory(DefinitionFactory $definitionFactory)
    {
        $this->definitionFactory = $definitionFactory;
    }

    protected function setup()
    {
        $this->addRequiredOption('output');
        $this->addRequiredOption('namespace');
        $this->addRequiredOption('outputFactory');
        $this->addRequiredOption('definitionFactory');
        $this->addRequiredOption('baseModelsNamespace');
    }

    protected function doClassProcess()
    {
        $this->generateClass();
    }

    protected abstract function generateClass();

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

        return str_replace($this->getOption('baseModelsNamespace'), '', $className);
    }

    protected function getLastBackslashPosition($className)
    {
        return strrpos($className, '\\');
    }
}