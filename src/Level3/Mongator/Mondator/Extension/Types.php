<?php

namespace Level3\Mongator\Mondator\Extension;

use Level3\Mongator\Mondator\Extension\Type\Type;

class Types
{
    private $types = array();

    public function register(Type $type)
    {
        $this->types[$type->getTypeName()] = $type;
    }

    public function has($typeName)
    {
        return isset($this->types[$typeName]);
    }

    public function get($typeName)
    {
        if (!$this->has($typeName)) {
            return null;
        }

        return $this->types[$typeName];
    }

    public function toResponse($typeName)
    {
        $type = $this->get($typeName);
        if ($type) {
            return $type->toResponse();
        }

        return null;
    }

    public function fromRequest($typeName)
    {
        $type = $this->get($typeName);
        if ($type) {
            return $type->fromRequest();
        }

        return null;    
    }
}