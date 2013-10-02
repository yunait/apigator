<?php

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Level3\\Mongator\\Tests', __DIR__);
$loader->add('Rest', __DIR__);
$loader->add('Model', __DIR__);

// mondator
$configClasses = require __DIR__.'/config_classes.php';

use \Mandango\Mondator\Mondator;

$mondator = new Mondator();
$mondator->setConfigClasses($configClasses);
$mondator->setExtensions(array(
    new Mongator\Extension\Core(array(
        'metadata_factory_class'  => 'Model\Mapping\MetadataFactory',
        'metadata_factory_output' => __DIR__,
        'default_output'          => __DIR__,
    )),
));

$mondator->process();

$options = array(
    'default_output' => __DIR__,
    'namespace' => 'Rest',
    'models_namespace' => 'Model\\'
);

$configClasses = array();
$metadata = new Model\Mapping\MetadataFactory();
foreach ($metadata->getDocumentClasses() as $class) {
    $configClasses[$class] = $metadata->getClass($class);
}

$mondator = new Mondator();
$mondator->setConfigClasses($configClasses);
$mondator->setExtensions(array(
    new Level3\Mongator\Mondator\Extension\Level3($options)

));

$mondator->process();
