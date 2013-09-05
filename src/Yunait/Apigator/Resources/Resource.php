<?php

namespace Yunait\Apigator\Resources;

use Mongator\Query\Chunk;
use Mongator\Document\Document;
use Level3\Exceptions;

abstract class Resource extends \Level3\Repository implements \Level3\Repository\Getter, \Level3\Repository\Finder, \Level3\Repository\Putter, \Level3\Repository\Poster, \Level3\Repository\Deleter
{
    const MAX_PAGE_SIZE = 100;

    protected $documentRepository;
    protected $collectionName;

    public function setDocumentRepository($documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function find($sort, $lowerBound, $upperBound, array $criteria)
    {
        $criteria = $this->parseCriteriaTypes($criteria);
        $builder = $this->createResourceBuilder();
        $documents = $this->getDocumentsFromDatabase($sort, $lowerBound, $upperBound, $criteria);

        foreach ($documents as $id => $document) {
            $builder->withEmbedded($this->collectionName, $this->getKey(), $id);
        }

        return $builder->build();
    }

    protected function getDocumentsFromDatabase($sort, $lowerBound, $upperBound, array $criteria)
    {
        $query = $this->documentRepository->createQuery();

        foreach ($criteria as $key => $value) {
            $queryMethodName = sprintf('findBy%s', ucfirst($key));
            if (method_exists($query, $queryMethodName)) {
                $query->$queryMethodName($value);
            }
        }

        list($page, $pageSize) = $this->boundsToPageAndPageSize($lowerBound, $upperBound);
        $chunk = $this->getChunk($sort, $page, $pageSize);
        $result = $chunk->getResult($query);
        return $result;
    }

    private function boundsToPageAndPageSize($lowerBound, $upperBound)
    {
        if ($upperBound == 0) {
            $pageSize = self::MAX_PAGE_SIZE;
        } else {
            $pageSize = min($upperBound - $lowerBound, self::MAX_PAGE_SIZE);
        }

        $page = $lowerBound / $pageSize;
        return array($page, $pageSize);
    }

    protected function getChunk($sort, $page, $pageSize)
    {
        return (new Chunk())->set($sort, $page, $pageSize);
    }

    public function get($id)
    {
        $document = $this->getDocument($id);
        return $this->getDocumentAsResource($document);
    }

    public function put($data)
    {
        $document = $this->documentRepository->create();
        $document->fromArray($data);
        $document->save();

        return $this->getDocumentAsResource($document);
    }

    public function post($id, $data)
    {
        $document = $this->getDocument($id);
        unset($data['id']);
        
        $document->fromArray($data);
        $document->save();
        
        return $this->getDocumentAsResource($document);
    }

    public function delete($data)
    {
        $document = $this->documentRepository->findById(array($id));
        if (!$document) {
            throw new Exceptions\NotFound();
        }
        $this->documentRepository->delete($document);
    }

    protected function getDocument($id)
    {
        $result = $this->documentRepository->findById([$id]);
        if ($result) {
            return end($result);
        } else {
            throw new Exceptions\NotFound();
        }
    }

    abstract protected function getDocumentAsResource(Document $document);

    abstract protected function parseCriteriaTypes(array $criteria);
}

