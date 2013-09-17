<?php

namespace Level3\Mongator\Messages\Processors;

use Level3\Messages\Processors\RequestProcessor;
use Level3\Messages\Request;
use Level3\Hal\Resource;
use Level3\Hal\ResourceBuilderFactory;

class DefinitionPublisher implements RequestProcessor
{
    const SCHEMA_KEY = '_schema';

    private $processor;
    private $resourceBuilderFactory;
    private $allowdLogLevels;

    public function __construct(RequestProcessor $processor, ResourceBuilderFactory $resourceBuilderFactory)
    {
        $this->resourceBuilderFactory = $resourceBuilderFactory;
        $this->processor = $processor;
    }

    public function find(Request $request)
    {
        $response = $this->processor->find($request);
        $this->addSchemaToResource($response->getResource());

        return $response;
    }

    public function get(Request $request)
    {
        $response = $this->processor->get($request);
        $this->addSchemaToResource($response->getResource());

        return $response;
    }

    public function post(Request $request)
    {
        $response = $this->processor->post($request);
        $this->addSchemaToResource($response->getResource());

        return $response;
    }

    public function put(Request $request)
    {
        $response = $this->processor->put($request);
        $this->addSchemaToResource($response->getResource());

        return $response;
    }

    public function delete(Request $request)
    {
        return $this->processor->delete($request);
    }

    protected function addSchemaToResource(Resource $resource)
    {
        $builder = $this->createResourceBuilder();
        $metadata = $resource->repository->getDocumentRepository()->getMetadata();

        $builder->withData($metadata);
        $resource->addResource(self::SCHEMA_KEY, $builder->build());
    }

    protected function createResourceBuilder()
    {
        return $this->resourceBuilderFactory->create();
    }
}


