<?php

namespace Level3\Mongator\Processor\Wrapper;

use Mongator\Mongator;
use Level3\Messages\Request;
use Level3\Messages\Response;
use Level3\Processor\Wrapper;
use Level3\Resource;
use Closure;

class DefinitionInjector extends Wrapper
{   
    protected $mongator;

    public function __construct(Mongator $mongator)
    {
        $this->mongator = $mongator;
    }

    public function error(Closure $execution, Request $request)
    {
        return $execution($request);
    }
    
    protected function processRequest(Closure $execution, Request $request, $method)
    {
        $response = $execution($request);

        $key = $request->getKey();
        $resource = $response->getResource();

        if (!$key || !$resource) {
            return $response;
        }

        $this->injectDefinitionAsResource($key, $resource);

        return $response;
    }

    protected function injectDefinitionAsResource($key, Resource $resource)
    {
        if (!$key) {
            return false;
        }

        $resourceRepository = $this->getLevel3()->getRepository($key);
        $documentRepository = $resourceRepository->getDocumentRepository();

        $metadata = $documentRepository->getMetadata();

        $definitionResource = new Resource();
        $definitionResource->setData($metadata);

        $resource->addResource('definition', $definitionResource);
    }
}