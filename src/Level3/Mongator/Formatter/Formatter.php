<?php

namespace Level3\Mongator\Formatter;
use Level3\Hal\ResourceBuilder;
use Mongator\Document\AbstractDocument;

abstract class Formatter
{
    protected $types;

    public function __construct()
    {
        $this->loadTypes();
    }

    protected function loadTypes()
    {
        $this->types = new Types();
        $this->types->register(new Type\MongoId());
        $this->types->register(new Type\DateTime());
    }

    abstract public function toResponse(ResourceBuilder $builder, AbstractDocument $document);
    abstract public function fromRequest(Array $data);
}