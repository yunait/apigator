<?php

namespace Yunait\Apigator\Mondator\Extension;

use Mandango\Mondator\Definition\Constant;
use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;

class BaseDocumentRepositoryContainer extends ApigatorExtension
{
    const CLASSES_NAMESPACE = 'RepositoryMapping\Base';
    const CLASSES_PREFIX = '';
    const CLASSES_SUFFIX = 'MongatorDocumentRepositoryContainer';

    public function __construct($options = array())
    {
        parent::__construct($options);

        $this->classesNamespace = self::CLASSES_NAMESPACE;
        $this->classesPrefix = self::CLASSES_PREFIX;
        $this->classesSuffix = self::CLASSES_SUFFIX;
    }

    protected function generateClass()
    {
        $output = $this->outputFactory->create($this->getOption('output'), true);
        $targetClassName = $this->getTargetClass('');
        $definition = $this->definitionFactory->create($targetClassName, $output);

        $this->definitions['documentRepositoryContainer'] = $definition;
        $definition->addInterface('\Level3\Silex\DocumentRepositoryContainer');
        $this->addFieldsToDefinition($definition);

        $this->addMethodsToDefinition($definition);
    }

    private function addFieldsToDefinition(Definition $definition)
    {
        $maxPageSize = new Constant('MAX_PAGE_SIZE', 100);
        $definition->addConstant($maxPageSize);

        $cache = new Property('private', 'mongator', null);
        $definition->addProperty($cache);

        $app = new Property('private', 'documentRepositoryMapping', null);
        $definition->addProperty($app);
    }

    protected function addMethodsToDefinition($definition)
    {
        $this->addConstructorToDefinition($definition);
        $this->addGetRepositoryForResourceToDefinition($definition);
        $this->addGetDocumentNameForResourceToDefinition($definition);
    }

    private function addConstructorToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $code = "        \$this->mongator = \$mongator;\n\n";
        $code = $code . "        \$this->documentRepositoryMapping = array(\n";

        foreach ($this->configClasses as $class => $config) {
            if ($config['isEmbedded']) {
                continue;
            }
            $code = $code .'            ' .
                '\'' . $this->getOption('namespace') . '\\' . EmptyResourceExtension::CLASSES_NAMESPACE . '\\' . $this->getClassName($class) . '\' => ' .
                '\'' . $class . "',\n";
        }

        $code = $code . '        );';

        $method = new Method('public', '__construct', '\Mongator\Mongator $mongator', $code);
        $definition->addMethod($method);
    }

    private function addGetRepositoryForResourceToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $code =
<<<EOF
        \$documentName = \$this->getDocumentNameForResource(\$className);
        return \$this->mongator->getRepository(\$documentName);
EOF;
        $definition->addMethod(new Method('public', 'getRepositoryForResource', '$className', $code));
    }

    private function addGetDocumentNameForResourceToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $code = '        return $this->documentRepositoryMapping[$className];';
        $definition->addMethod(new Method('public', 'getDocumentNameForResource', '$className', $code));
    }

}