<?php

namespace Level3\Mongator\Processor\Wrapper;

use Mongator\Mongator;
use Level3\Repository;
use Level3\Messages\Request;
use Level3\Messages\Response;
use Level3\Processor\Wrapper;
use Level3\Resource\Resource;
use Closure;

class DefinitionInjector extends Wrapper
{   
    protected $mongator;

    public function __construct(Mongator $mongator)
    {
        $this->mongator = $mongator;
    }

    public function error(Repository $repository, Request $request, Callable $execution)
    {
        return $execution($request);
    }
    
    protected function processRequest(Repository $repository, Request $request, Callable $execution, $method)
    {
        $response = $execution($repository, $request);

        $key = $repository->getKey();
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