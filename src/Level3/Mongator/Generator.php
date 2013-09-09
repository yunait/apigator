<?php

namespace Level3\Mongator;

use Mandango\Mondator\Extension;
use Mandango\Mondator\Mondator;
use Mongator\Mongator;
use Level3\Mongator\Mondator\Definition\DefinitionFactory;
use Level3\Mongator\Mondator\Extension\ExtensionFactory;
use Level3\Mongator\Mondator\OutputFactory;

class Generator
{
    private $mongator;
    private $mondator;
    private $extensionFactory;
    private $outputFactory;
    private $definitionFactory;

    public function __construct(Mongator $mongator, Mondator $mondator)
    {
        $this->mongator = $mongator;
        $this->mondator = $mondator;
    }

    public function setExtensionFactory(ExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    public function setOutputFactory(OutputFactory $outputFactory)
    {
        $this->outputFactory = $outputFactory;
    }

    public function setDefinitionFactory(DefinitionFactory $definitionFactory)
    {
        $this->definitionFactory = $definitionFactory;
    }

    public function generateApi($rootPath, $rootNamespace, $modelBaseNamespace)
    {
        echo("Generating API for $rootNamespace under $rootPath\n");
        $classes = $this->mongator->getMetadataFactory()->getClasses();
        $this->setMondatorConfig($classes);
        $this->addMondatorExtensions($rootPath, $rootNamespace, $modelBaseNamespace);
        $this->mondator->process();
    }

    private function setMondatorConfig(array $classes)
    {
        foreach ($classes as $class) {
            $this->mondator->setConfigClass($class, $this->mongator->getMetadata($class));
        }
    }

    private function addMondatorExtensions($rootPath, $rootNamespace, $modelBaseNamespace)
    {
        $baseResourcesOptions = array(
            'output' => $rootPath,
            'namespace' => $rootNamespace,
            'baseModelsNamespace' => $modelBaseNamespace,
            'outputFactory' => $this->outputFactory,
            'definitionFactory' => $this->definitionFactory,
        );

        $extensions = $this->extensionFactory->createExtensions($baseResourcesOptions);
        foreach ($extensions as $extension) {
            $this->mondator->addExtension($extension);
        }
    }
}
