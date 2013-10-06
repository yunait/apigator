<?php

namespace Level3\Mongator\Mondator\Extension\Type;

abstract class Type
{
    protected $typeName;

    public function getTypeName()
    {
        return $this->typeName;
    }

    abstract public function fromRequest();
    abstract public function toResponse();
}