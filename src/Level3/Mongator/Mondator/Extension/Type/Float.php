<?php

namespace Level3\Mongator\Mondator\Extension\Type;

class Float extends Type
{
    protected $typeName = 'float';

    public function fromRequest()
    {
        return '(float) $string';
    }

    public function toResponse()
    {
        return '(float) $string';
    }
}
