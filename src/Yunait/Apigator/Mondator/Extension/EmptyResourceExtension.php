<?php

namespace Yunait\Apigator\Mondator\Extension;

use Mandango\Mondator\Definition\Constant;
use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;
use Mandango\Mondator\Extension;
use Yunait\Apigator\Mondator\Definition\DefinitionFactory;
use Yunait\Apigator\Mondator\OutputFactory;

class EmptyResourceExtension extends ApigatorExtension
{
    const CLASSES_NAMESPACE = 'Resources';

    private $outputFactory;
    private $definitionFactory;

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

    private function setDefinitionFactory(DefinitionFactory $definitionFactory){
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

    private function generateClass()
    {
        $output = $this->outputFactory->create($this->getOption('output'), true);
        $targetClassName = $this->getTargetClass($this->getClassName());
        $definition = $this->definitionFactory->create($targetClassName, $output);

        $this->definitions['emptyResource'] = $definition;
        $definition->setParentClass($this->getParentClass($this->getClassName()));
    }

    private function getTargetClass($class)
    {
        return $this->getOption('namespace') .
        '\\' .
        self::CLASSES_NAMESPACE .
        '\\' .
        $class;

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