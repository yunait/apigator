<?php

namespace Level3\Mongator\Formatter\Type;
use Level3\Mongator\Formatter\Type;
use MongoId as NativeMongoId;

class MongoId extends Type
{
    protected $class = 'MongoId';

    public function fromRequest($mongoIdString)
    {
        return new NativeMongoId($mongoIdString);
    }

    public function toResponse($mongoId)
    {
        return (string)$mongoId;
    }
}