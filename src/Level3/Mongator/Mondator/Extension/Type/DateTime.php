<?php

namespace Level3\Mongator\Mondator\Extension\Type;

use DateTime as NativeDateTime;

class DateTime extends Type
{
    protected $typeName = 'date';

    public function fromRequest()
    {
        return 'NativeDateTime::createFromFormat(\DateTime::ISO8601, $isoDate);';
    }

    public function toResponse()
    {
        return '$date->format(\DateTime::ISO8601);';
    }
}