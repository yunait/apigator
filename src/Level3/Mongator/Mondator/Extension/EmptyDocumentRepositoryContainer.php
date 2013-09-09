<?php

namespace Level3\Mongator\Mondator\Extension;

use Mandango\Mondator\Definition\Constant;
use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;

class EmptyDocumentRepositoryContainer extends Extension
{
    const CLASSES_NAMESPACE = 'RepositoryMapping';
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
        $output = $this->outputFactory->create($this->getOption('output'), false);
        $targetClassName = $this->getTargetClass('');
        $definition = $this->definitionFactory->create($targetClassName, $output);

        $this->definitions['emptyDocumentRepositoryContainer'] = $definition;
        $definition->setParentClass('\\' . $this->getOption('namespace') .
            '\\' .BaseDocumentRepositoryContainer::CLASSES_NAMESPACE.'\\'.BaseDocumentRepositoryContainer::CLASSES_SUFFIX);
    }
}