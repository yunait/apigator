<?php

namespace Yunait\Apigator\Mondator\Extension;

use Mandango\Mondator\Extension;
use Yunait\Apigator\Mondator\Definition\DefinitionFactory;
use Yunait\Apigator\Mondator\OutputFactory;

abstract class ApigatorExtension extends Extension
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
    }

    protected function doClassProcess()
    {
        if ($this->configClass['isEmbedded']) {
            return;
        }

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

        $lastBackslashPosition = $this->getLastBackslashPosition($className);
        return substr($className, $lastBackslashPosition + 1);
    }

    protected function getLastBackslashPosition($className)
    {
        return strrpos($className, '\\');
    }
}