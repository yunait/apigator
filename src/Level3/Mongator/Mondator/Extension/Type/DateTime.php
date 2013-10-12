<?php

namespace Level3\Mongator\Mondator\Extension\Type;

use DateTime as NativeDateTime;

class DateTime extends Type
{
    protected $typeName = 'date';

    public function fromRequest()
    {
        return '\DateTime::createFromFormat(\DateTime::ISO8601, $string)';
    }

    public function toResponse()
    {
        return '$object->format(\DateTime::ISO8601)';
    }
}