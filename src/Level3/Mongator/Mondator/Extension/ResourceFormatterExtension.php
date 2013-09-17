<?php

namespace Level3\Mongator\Mondator\Extension;

use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;
use Mongator\Twig\Mongator as MongatorTwig;

class ResourceFormatterExtension extends Extension
{
    const CLASSES_NAMESPACE = 'Resources\\Base';
    const CLASSES_PREFIX = '';
    const CLASSES_SUFFIX = 'Formatter';

    public function __construct($options = array())
    {
        parent::__construct($options);

        $this->classesNamespace = self::CLASSES_NAMESPACE;
        $this->classesPrefix = self::CLASSES_PREFIX;
        $this->classesSuffix = self::CLASSES_SUFFIX;
    }

    protected function generateClass()
    {
        $this->definitions['resourceBuilder'] = $this->definition;
        $this->definition->setAbstract(true);
        $this->definition->setParentClass('\Level3\Mongator\Formatter\Formatter');

        $this->processTemplate($this->definitions['resourceBuilder'],
            file_get_contents(__DIR__.'/templates/Formatter.php.twig')
        );
    }

    public function getResourceKey($class)
    {
        return strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $this->getClassName($class)));
    }

    protected function configureTwig(\Twig_Environment $twig)
    {
        $twig->addExtension(new MongatorTwig());
    }
}