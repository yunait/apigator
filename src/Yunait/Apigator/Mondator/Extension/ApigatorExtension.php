<?php

namespace Yunait\Apigator\Mondator\Extension;

use Mandango\Mondator\Extension;

abstract class ApigatorExtension extends Extension
{
    const CLASSES_NAMESPACE = 'Resources\\Base';
    const CLASSES_PREFIX = 'Base';
    protected $outputFactory;
    protected $definitionFactory;

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->setOutputFactory($this->getOption('outputFactory'));
        $this->setDefinitionFactory($this->getOption('definitionFactory'));
    }
}