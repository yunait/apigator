<?php

namespace Level3\Mongator\Resources;
use Level3\Hal\ResourceBuilder;

abstract class Formatter
{

    private $document;
    private $builder;
    protected $allowedKeys;

    public function __construct(ResourceBuilder $builder, $document)
    {
        $this->document = $document;
        $this->builder = $builder;
    }

    public function build()
    {
        $this->setData();
        $this->setLinks();

        return $this->builder->build();
    }

    public function getBuilder()
    {
        return $this->builder;
    }

    public function getDocument()
    {
        return $this->document;
    }

    protected function extractBasicInfo()
    {
        $documentArray = $this->document->toArray();
        $data = array('id' => $documentArray['id']);
        foreach ($documentArray as $key => $value) {
            if (in_array($key, $this->allowedKeys)) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    abstract protected function setData();

    abstract protected function setLinks();
}