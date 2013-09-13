<?php

namespace Level3\Mongator\Resources;

use Mongator\Query\Chunk;
use Mongator\Document\AbstractDocument;
use Level3\Exceptions;
use Level3\Messages\Parameters;
use BadMethodCallException;

abstract class Resource extends \Level3\Repository implements \Level3\Repository\Getter, \Level3\Repository\Finder, \Level3\Repository\Putter, \Level3\Repository\Poster, \Level3\Repository\Deleter
{
    const MAX_PAGE_SIZE = 100;
    const FIND_EMBEDDED_KEY = 'documents';
    const KEY_ID = 'id';

    protected $documentRepository;
    private $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDocumentRepository($documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function getDocumentRepository()
    {
        return $this->documentRepository;
    }

    public function find(Parameters $parameters, $sort, $lowerBound, $upperBound, Array $criteria)
    {
        $builder = $this->createResourceBuilder();

        $documents = $this->getDocuments($parameters, $sort, $lowerBound, $upperBound, $criteria);
        foreach ($documents as $id => $document) {
            $builder->withEmbedded(
                $this->getRelationsName(), 
                $this->getKey(), 
                $this->createParametersFromDocument($document)
            );
        }

        return $builder->build();
    }

    protected function createParametersFromDocument(AbstractDocument $document)
    {
        return new Parameters([self::KEY_ID => $document->getId()]);
    }

    protected function getDocuments(Parameters $parameters, $sort, $lowerBound, $upperBound, Array $criteria)
    {
        $criteria = $this->parseCriteriaTypes($criteria);

        return $this->getDocumentsFromDatabase($sort, $lowerBound, $upperBound, $criteria);
    }

    protected function getRelationsName()
    {
        return self::FIND_EMBEDDED_KEY;
    }

    protected function getDocumentsFromDatabase($sort, $lowerBound, $upperBound, Array $criteria)
    {
        $query = $this->createQuery($criteria);

        list($page, $pageSize) = $this->boundsToPageAndPageSize($lowerBound, $upperBound);
        $chunk = $this->getChunk($sort, $page, $pageSize);
        $result = $chunk->getResult($query);
        return $result;
    }

    private function createQuery(Array $criteria)
    {
        $query = $this->documentRepository->createQuery();
        $this->applyCriteriaToQuery($query, $criteria);

        return $query;
    }

    private function applyCriteriaToQuery($query, Array $criteria)
    {
        foreach ($criteria as $key => $value) {
            $value = urldecode($value);
            $this->applyMethodToQuery($query, $key, $value);
        }
    }

    private function applyMethodToQuery($query, $key, $value)
    {
        $method = sprintf('find%s', ucfirst($key));

        if (!method_exists($query, $method)) {
            throw new BadMethodCallException(sprintf('Invalid criteria "%s"', $key));
        }
    
        $query->$method($value);
    }

    private function boundsToPageAndPageSize($lowerBound, $upperBound)
    {
        if ($upperBound == 0) {
            $pageSize = self::MAX_PAGE_SIZE;
        } else {
            $pageSize = min($upperBound - $lowerBound + 1, self::MAX_PAGE_SIZE);
        }

        $page = $lowerBound / $pageSize;
        return array($page, $pageSize);
    }

    protected function getChunk($sort, $page, $pageSize)
    {
        return (new Chunk())->set($sort, $page, $pageSize);
    }

    public function get(Parameters $parameters)
    {
        $document = $this->getDocument($parameters);
        return $this->getDocumentAsResource($document);
    }

    public function put(Parameters $parameters, $data)
    {
        $document = $this->createDocument($parameters);
        $this->persistsDocument($document, $data);

        return $this->getDocumentAsResource($document);
    }

    public function post(Parameters $parameters, $data)
    {
        $document = $this->getDocument($parameters);
        unset($data['id']);
        
        $this->persistsDocument($document, $data);
        
        return $this->getDocumentAsResource($document);
    }

    public function delete(Parameters $parameters)
    {
        $document = $this->getDocument($parameters);
        $this->deleteDocument($document);
    }

    protected function createDocument(Parameters $parameters)
    {
        return $this->documentRepository->create();
    }

    protected function getDocument(Parameters $parameters)
    {
        $result = $this->documentRepository->findById([$parameters->get(self::KEY_ID)]);
        if ($result) {
            return end($result);
        } else {
            throw new Exceptions\NotFound();
        }
    }

    protected function persistsDocument(AbstractDocument $document, Array $data)
    {
        $document->fromArray($data);
        $document->save();
    }

    protected function deleteDocument(AbstractDocument $document)
    {
        $this->documentRepository->delete($document);
    }

    abstract protected function getDocumentAsResource(AbstractDocument $document);

    abstract protected function parseCriteriaTypes(array $criteria);
}

