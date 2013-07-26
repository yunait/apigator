<?php

namespace Yunait\Apigator;

use Mandango\Mondator\Extension;
use Mandango\Mondator\Mondator;
use Mongator\Mongator;
use Yunait\Apigator\Mondator\Definition\DefinitionFactory;
use Yunait\Apigator\Mondator\Extension\ExtensionFactory;
use Yunait\Apigator\Mondator\OutputFactory;

class Apigator
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

    public function generateApi($rootPath, $rootNamespace)
    {
        echo("Generating API for $rootNamespace under $rootPath\n");
        $classes = $this->mongator->getMetadataFactory()->getClasses();
        $this->setMondatorConfig($classes);
        $this->addMondatorExtensions($rootPath, $rootNamespace);
        $this->mondator->process();
    }

    private function setMondatorConfig(array $classes)
    {
        foreach ($classes as $class) {
            $this->mondator->setConfigClass($class, $this->mongator->getMetadata($class));
        }
    }

    private function addMondatorExtensions($rootPath, $rootNamespace)
    {
        $baseResourcesOptions = array(
            'output' => $rootPath,
            'namespace' => $rootNamespace,
            'outputFactory' => $this->outputFactory,
            'definitionFactory' => $this->definitionFactory
        );

        $resourceOptions = array_merge($baseResourcesOptions, array('repositoryNamePrefix' => 'repository.daily.'));

        $resourceExtension = $this->extensionFactory->createResourceExtension($resourceOptions);
        $baseResourceExtension = $this->extensionFactory->createBaseResourceExtension($baseResourcesOptions);
        $emptyResourceExtension = $this->extensionFactory->createEmptyResourceExtension($baseResourcesOptions);
        $baseBuilderExtension = $this->extensionFactory->createResourceBuilderBaseExtension($baseResourcesOptions);
        $builderExtension = $this->extensionFactory->createResourceBuilderExtension($baseResourcesOptions);
        $emptyResourceBuilderExtension = $this->extensionFactory->createEmptyResourceBuilderExtension($baseResourcesOptions);

        $this->mondator->addExtension($resourceExtension);
        $this->mondator->addExtension($baseResourceExtension);
        $this->mondator->addExtension($emptyResourceExtension);
        $this->mondator->addExtension($baseBuilderExtension);
        $this->mondator->addExtension($builderExtension);
        $this->mondator->addExtension($emptyResourceBuilderExtension);
    }
}