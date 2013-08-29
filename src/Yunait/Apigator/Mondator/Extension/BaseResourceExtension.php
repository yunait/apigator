<?php

namespace Yunait\Apigator\Mondator\Extension;

use Mandango\Mondator\Definition\Constant;
use Mandango\Mondator\Definition\Definition;
use Mandango\Mondator\Definition\Method;
use Mandango\Mondator\Definition\Property;

class BaseResourceExtension extends ApigatorExtension
{
    const CLASSES_NAMESPACE = 'Resources\\Base';
    const CLASSES_PREFIX = '';
    const CLASSES_SUFFIX = 'Resource';

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

        $this->definitions['baseResource'] = $definition;
        $definition->setParentClass('\\Level3\\Repository');
        $definition->addInterface('\\Level3\\Repository\\Getter');
        $definition->addInterface('\\Level3\\Repository\\Finder');
        $definition->addInterface('\\Level3\\Repository\\Putter');
        $definition->addInterface('\\Level3\\Repository\\Poster');
        $definition->addInterface('\\Level3\\Repository\\Deleter');
        $definition->setAbstract(true);
        $this->addFieldsToDefinition($definition);

        $this->addMethodsToDefinition($definition);
    }

    private function addFieldsToDefinition(Definition $definition)
    {
        $maxPageSize = new Constant('MAX_PAGE_SIZE', 100);
        $definition->addConstant($maxPageSize);

        $cache = new Property('protected', 'documentRepository', null);
        $definition->addProperty($cache);

        $app = new Property('protected', 'collectionName', null);
        $definition->addProperty($app);
    }

    protected function addMethodsToDefinition($definition)
    {
        $this->addSetDocumentRepositoryMethodToDefinition($definition);
        $this->addFindMethodToDefinition($definition);
        $this->addGetDocumentsFromDatabaseMethodToDefinition($definition);
        $this->addLimitBoundsMethodToDefinition($definition);
        $this->addGetMethodToDefinition($definition);
        $this->addPutMethodToDefinition($definition);
        $this->addPostMethodToDefinition($definition);
        $this->addDeleteMethodToDefinition($definition);
        $this->addGetDocumentMethodToDefinition($definition);
        $this->addGetDocumentAsResourceMethodToDefinition($definition);
        $this->addParseCriteriaTypesMethodToDefinition($definition);
    }

    private function addSetDocumentRepositoryMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $method = new Method('public', 'setDocumentRepository', '$documentRepository',
<<<EOF
        \$this->documentRepository = \$documentRepository;
EOF
        );

        $definition->addMethod($method);
    }

    private function addFindMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $method = new Method('public', 'find', '$lowerBound, $upperBound, array $criteria',
<<<EOF
        \$criteria = \$this->parseCriteriaTypes(\$criteria);
        \$builder = \$this->createResourceBuilder();
        \$documents = \$this->getDocumentsFromDatabase(\$lowerBound, \$upperBound, \$criteria);

        foreach (\$documents as \$id => \$document) {
            \$builder->withEmbedded(\$this->collectionName, \$this->getKey(), \$id);
        }

        return \$builder->build();
EOF
        );

        $definition->addMethod($method);
    }

    private function addGetDocumentsFromDatabaseMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $method = new Method('protected', 'getDocumentsFromDatabase', '$lowerBound, $upperBound, array $criteria',
<<<EOF
        \$bounds = \$this->limitBounds(\$lowerBound, \$upperBound);
        \$query = \$this->documentRepository->createQuery();

        foreach (\$criteria as \$key => \$value) {
            \$queryMethodName = sprintf('findBy%s', ucfirst(\$key));
            if (method_exists(\$query, \$queryMethodName)) {
                \$query->\$queryMethodName(\$value);
            }
        }

        \$query->skip(\$bounds[0])->limit(\$bounds[1]);
        \$result = \$query->execute();
        return \$result;
EOF
        );

        $definition->addMethod($method);
    }

    private function addLimitBoundsMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $method = new Method('private', 'limitBounds', '$lowerBound, $upperBound',
<<<EOF
        if (\$lowerBound === 0 && \$upperBound === 0) {
            return array(0, self::MAX_PAGE_SIZE);
        }

        if (\$upperBound - \$lowerBound > self::MAX_PAGE_SIZE) {
            return array(\$lowerBound, \$lowerBound + self::MAX_PAGE_SIZE);
        }

        return array(\$lowerBound, \$upperBound - \$lowerBound +1);
EOF
        );

        $definition->addMethod($method);
    }

    private function addGetMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $method = new Method('public', 'get', '$id',
<<<EOF
        \$document = \$this->getDocument(\$id);
        return \$this->getDocumentAsResource(\$document);
EOF
        );

        $definition->addMethod($method);
    }

    private function addGetDocumentMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $method = new Method('protected', 'getDocument', '$id',
<<<EOF
        \$result = \$this->documentRepository->findById([\$id]);
        if (\$result) return end(\$result);
        return null;
EOF
        );

        $definition->addMethod($method);
    }

    private function addGetDocumentAsResourceMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $method = new Method('protected', 'getDocumentAsResource', '\Mongator\Document\Document $document', null);
        $method->setAbstract(true);

        $definition->addMethod($method);
    }

    private function addParseCriteriaTypesMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $method = new Method('protected', 'parseCriteriaTypes', 'array $criteria', null);
        $method->setAbstract(true);

        $definition->addMethod($method);
    }

    private function addPutMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $method = new Method('public', 'put', '$data',
<<<EOF
        \$document = \$this->documentRepository->create(\$data);
        \$this->documentRepository->save(\$document);
        return \$document;
EOF
        );

        $definition->addMethod($method);
    }

    private function addPostMethodToDefinition(\Mandango\Mondator\Definition $definition)
    {
        $method = new Method('public', 'post', '$id, $data',
<<<EOF
        die("Posting data to \$id");
EOF
        );

        $definition->addMethod($method);
    }

    private function addDeleteMethodToDefinition(\Mandango\Mondator\Definition $definition){
        $method = new Method('public', 'delete', '$data',
<<<EOF
        \$document = \$this->documentRepository->findById(array(\$id));
        if (!\$document) {
            throw new \Level3\Exceptions\NotFound();
        }
        \$this->documentRepository->delete(\$document);
EOF
        );

        $definition->addMethod($method);
    }
}
