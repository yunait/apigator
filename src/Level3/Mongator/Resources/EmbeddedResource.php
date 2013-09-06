<?php

namespace Level3\Mongator\Resources;

use Mongator\Query\Chunk;
use Mongator\Document\Document;
use Mongator\Document\AbstractDocument;
use Level3\Exceptions;
use stdClass;
use Exception;

abstract class EmbeddedResource extends Resource
{
    protected function getDocument(stdClass $parameters)
    {
        $document = $this->getParentDocument($parameters);
        return $document->getPhotos()->one();
    }

    protected function getParentDocument(stdClass $parameters)
    {
        return parent::getDocument($parameters);
    }

    protected function persistsDocument(AbstractDocument $document)
    {
        throw new Exception('Not implemented: ' . __METHOD__);
        
    }

    protected function deleteDocument(AbstractDocument $document)
    {
        throw new Exception('Not implemented: ' . __METHOD__);
    }
}

