<?php

namespace Level3\Mongator\Formatter;


abstract class Type
{
    protected $class;

    public function getClass()
    {
        return $this->class;
    }

    abstract public function fromRequest($input);
    abstract public function toResponse($input);
}