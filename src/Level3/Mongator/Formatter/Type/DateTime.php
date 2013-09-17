<?php

namespace Level3\Mongator\Formatter\Type;
use Level3\Mongator\Formatter\Type;
use DateTime as NativeDateTime;

class DateTime extends Type
{
    protected $class = 'DateTime';

    public function fromRequest($isoDate)
    {
        return NativeDateTime::createFromFormat(NativeDateTime::ISO8601, $isoDate);
    }

    public function toResponse($dateTime)
    {
        return $dateTime->format(NativeDateTime::ISO8601);
    }
}