<?php

namespace Level3\Mongator\Mondator\Extension\Type;

use MongoId as NativeMongoId;

class MongoId extends Type
{
    protected $typeName = 'MongoId';

    public function fromRequest()
    {
        return 'new \MongoId($string)';
    }

    public function toResponse()
    {
        return '(string) $object';
    }
}