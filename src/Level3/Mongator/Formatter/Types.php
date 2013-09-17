<?php

namespace Level3\Mongator\Formatter;
use Level3\Hal\ResourceBuilder;
use Mongator\Document\AbstractDocument;

class Types
{
    private $types = [];

    public function register(Type $type)
    {
        $this->types[$type->getClass()] = $type;
    }

    public function has($class)
    {
        return isset($this->types[$class]);
    }

    public function get($class)
    {
        if (!$this->has($class)) {
            return null;
        }

        return $this->types[$class];
    }

    public function findForObject($object)
    {
        $class = get_class($object);
        return $this->get($class);
    }

    public function toResponseArray(Array $data)
    {
        foreach ($data as $key => $value) {
            if (!is_object($value)) continue;

            $class = get_class($value);
            $data[$key] = $value = $this->toResponse($class, $value);
            if (!$value) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    public function toResponse($class, $object)
    {
        $type = $this->get($class);
        if ($type) {
            return $type->toResponse($object);
        }

        return null;
    }

    public function fromRequest($class, $value)
    {
        $type = $this->get($class);
        if ($type) {
            return $type->fromRequest($value);
        }

        return null;    
    }
}