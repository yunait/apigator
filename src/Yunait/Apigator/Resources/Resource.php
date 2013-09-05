<?php

namespace Yunait\Apigator\Resources;

abstract class Resource extends \Level3\Repository implements \Level3\Repository\Getter, \Level3\Repository\Finder, \Level3\Repository\Putter, \Level3\Repository\Poster, \Level3\Repository\Deleter
{
    const MAX_PAGE_SIZE = 100;

    protected $documentRepository;
    protected $collectionName;

    public function setDocumentRepository($documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function find($lowerBound, $upperBound, array $criteria)
    {
        $criteria = $this->parseCriteriaTypes($criteria);
        $builder = $this->createResourceBuilder();
        $documents = $this->getDocumentsFromDatabase($lowerBound, $upperBound, $criteria);

        foreach ($documents as $id => $document) {
            $builder->withEmbedded($this->collectionName, $this->getKey(), $id);
        }

        return $builder->build();
    }

    protected function getDocumentsFromDatabase($lowerBound, $upperBound, array $criteria)
    {
        $query = $this->documentRepository->createQuery();

        foreach ($criteria as $key => $value) {
            $queryMethodName = sprintf('findBy%s', ucfirst($key));
            if (method_exists($query, $queryMethodName)) {
                $query->$queryMethodName($value);
            }
        }

        $bounds = $this->limitBounds($lowerBound, $upperBound);
        $query = $this->applyOffsetAndLimitToQuery($query, $bounds[0], $bounds[1]);
        $result = $this->extractResultFromQuery($query);
        return $result;
    }

    private function limitBounds($lowerBound, $upperBound)
    {
        if ($lowerBound === 0 && $upperBound === 0) {
            return array(0, self::MAX_PAGE_SIZE);
        }

        if ($upperBound - $lowerBound > self::MAX_PAGE_SIZE) {
            return array($lowerBound, $lowerBound + self::MAX_PAGE_SIZE);
        }

        return array($lowerBound, $upperBound - $lowerBound +1);
    }

    protected function applyOffsetAndLimitToQuery($query, $offset, $limit)
    {
        $query->skip($offset)->limit($limit);
        return $query;
    }

    protected function extractResultFromQuery($query)
    {
        return $query->execute();
    }

    public function get($id)
    {
        $document = $this->getDocument($id);
        return $this->getDocumentAsResource($document);
    }

    public function put($data)
    {
        $document = $this->documentRepository->create($data);
        $this->documentRepository->save($document);
        return $document;
    }

    public function post($id, $data)
    {
        die("Posting data to $id");
    }

    public function delete($data)
    {
        $document = $this->documentRepository->findById(array($id));
        if (!$document) {
            throw new \Level3\Exceptions\NotFound();
        }
        $this->documentRepository->delete($document);
    }

    protected function getDocument($id)
    {
        $result = $this->documentRepository->findById([$id]);
        if ($result) return end($result);
        return null;
    }

    abstract protected function getDocumentAsResource(\Mongator\Document\Document $document);

    abstract protected function parseCriteriaTypes(array $criteria);
}

