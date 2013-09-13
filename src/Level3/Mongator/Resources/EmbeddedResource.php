<?php

namespace Level3\Mongator\Resources;

use Mongator\Query\Chunk;
use Mongator\Document\Document;
use Mongator\Document\AbstractDocument;
use Level3\Exceptions;
use Level3\Messages\Parameters;
use Exception;

abstract class EmbeddedResource extends Resource
{
    const KEY_EMBEDDED_ID = 'embeddedId';

    protected function createParametersFromDocument(AbstractDocument $embedded)
    {
        $rap = $embedded->getRootAndPath();

        return new Parameters([
            self::KEY_ID => $rap['root']->getId(),
            self::KEY_EMBEDDED_ID => $embedded->getId()
        ]);
    }

    protected function getDocuments(Parameters $parameters, $sort, $lowerBound, $upperBound, Array $criteria)
    {
        $document = $this->getParentDocument($parameters);

        return $this->getEmbeddedGroup($document);
    }

    protected function getDocument(Parameters $parameters)
    {
        $document = $this->getParentDocument($parameters);

        $group = $this->getEmbeddedGroup($document);
        
        if (count($group) != 0) {
            foreach ($group as $embedded) {
                if ($embedded->getId() == $parameters->get(self::KEY_EMBEDDED_ID)) {
                    return $embedded;
                }
            }
        } 

        throw new Exceptions\NotFound();
    }
    
    private function getEmbeddedGroup(Document $document)
    {
        $method = sprintf('get%s', ucfirst($this->getName()));
        return $document->$method();
    }

    private function getParentDocument(Parameters $parameters)
    {
        return parent::getDocument($parameters);
    }


    protected function persistsDocument(AbstractDocument $embedded, Array $data)
    {
        $embedded->fromArray($data);

        $rap = $embedded->getRootAndPath();
        $rap['root']->save();
    }

    protected function deleteDocument(AbstractDocument $embedded)
    {
        $rap = $embedded->getRootAndPath();
        $document = $rap['root'];

        $addMethod = sprintf('remove%s', ucfirst($this->getName()));
        $document->$addMethod($embedded);
        $document->save();
    }

    protected function createDocument(Parameters $parameters)
    {
        $document = parent::getDocument($parameters);

        $tmp = explode('\\', get_class($this));
        $class = end($tmp);

        $createMethod = sprintf('create%s', ucfirst($class));
        $embedded = $document->$createMethod();

        $addMethod = sprintf('add%s', ucfirst($this->getName()));
        $document->$addMethod($embedded);


        $embedded->setRootAndPath($document, $this->getName());
        return $embedded;
    }
}

