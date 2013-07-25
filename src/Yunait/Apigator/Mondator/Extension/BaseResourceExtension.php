<?php

namespace Yunait\Apigator\Mondator\Extension;

use Mandango\Mondator\Definition\Constant;
use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;
use Mandango\Mondator\Extension;
use Yunait\Apigator\Mondator\Definition\DefinitionFactory;
use Yunait\Apigator\Mondator\OutputFactory;

class BaseResourceExtension extends ApigatorExtension
{
    const CLASSES_NAMESPACE = 'Resources\\Base';
    const CLASSES_PREFIX = 'Base';
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

    private function generateClass()
    {
        $output = $this->outputFactory->create($this->getOption('output'), true);
        $targetClassName = $this->getTargetClass($this->getClassName());
        $definition = $this->definitionFactory->create($targetClassName, $output);

        $this->definitions['baseResource'] = $definition;
        $definition->setParentClass('\\Level3\\Repository');
        $this->addFieldsToDefinition($definition);

        $definition->addMethod($this->createConstructorMethod());
        $definition->addMethod($this->createGetAppMethod());
        $definition->addMethod($this->createGetDocumentMethod());
        $definition->addMethod($this->createGetDocumentRepositoryMethod());
        $definition->addMethod($this->createConvertRangeToPageNumber());
        $definition->addMethod($this->createConvertRangeToPageSize());


    }

    private function getTargetClass()
    {
        return $this->getOption('namespace') .
        '\\' .
        self::CLASSES_NAMESPACE .
        '\\' .
        self::CLASSES_PREFIX;

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

    private function addFieldsToDefinition(Definition $definition)
    {
        $maxPageSize = new Constant('MAX_PAGE_SIZE', 100);
        $definition->addConstant($maxPageSize);

        $cache = new Property('private', 'cache', null);
        $definition->addProperty($cache);

        $app = new Property('private', 'app', null);
        $definition->addProperty($app);
    }

    private function createConstructorMethod()
    {
        $constructor = new Method('public', '__construct', 'Silex\\Application $app',
            <<<EOF
                    \$this->app = \$app;
        \$this->cache = [];
EOF
        );
        return $constructor;
    }

    private function createGetAppMethod()
    {
        $method = new Method('protected', 'getApp', '',
            <<<EOF
                    return \$this->app;
EOF
        );
        return $method;
    }

    private function createGetDocumentMethod()
    {
        $method = new Method('protected', 'getDocument', '$id',
            <<<EOF
                    \$result = \$this->getDocumentepository()->getRepository()->findById([\$id]);
        if (\$result) return end(\$result);
        return null;
EOF
        );
        return $method;
    }

    private function createGetDocumentRepositoryMethod()
    {
        $method = new Method('protected', 'getDocumentRepository', '',
            <<<EOF
                    return \$this->app['core']->get(\$this->documentRepository);
EOF
        );
        return $method;
    }

    private function createConvertRangeToPageNumber()
    {
        $method = new Method('protected', 'convertRangeToPageNumber', '$lowerBound = 0, $upperBound = 0',
            <<<EOF
                    \$pageSize = \$this->convertRangeToPageSize(\$lowerBound, \$upperBound);

        return intval(\$lowerBound/\$pageSize);
EOF
        );
        return $method;
    }

    private function createConvertRangeToPageSize()
    {
        $method = new Method('protected', 'convertRangeToPageSize', '$lowerBound = 0, $upperBound = 0',
            <<<EOF
                    \$pageSize = \$upperBound - \$lowerBound;

        if (\$pageSize > self::MAX_PAGE_SIZE) return self::MAX_PAGE_SIZE;
        if (\$pageSize == 0) return self::MAX_PAGE_SIZE;
        return \$pageSize;
EOF
        );
        return $method;
    }
}