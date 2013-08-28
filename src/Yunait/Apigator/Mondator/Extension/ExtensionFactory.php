<?php

namespace Yunait\Apigator\Mondator\Extension;

class ExtensionFactory
{
    public function createResourceExtension($options = array())
    {
        return new ResourceExtension($options);
    }

    public function createBaseResourceExtension($options = array())
    {
        return new BaseResourceExtension($options);
    }

    public function createEmptyResourceExtension($options = array())
    {
        return new EmptyResourceExtension($options);
    }

    public function createResourceBuilderBaseExtension($options = array())
    {
        return new ResourceBuilderBaseExtension($options);
    }

    public function createResourceBuilderExtension($options = array())
    {
        return new ResourceBuilderExtension($options);
    }

    public function createEmptyResourceBuilderExtension($options = array())
    {
        return new EmptyResourceBuilderExtension($options);
    }

    public function createBaseDocumentRepositoryContainer($options = array())
    {
        return new BaseDocumentRepositoryContainer($options);
    }

    public function createEmptyDocumentRepositoryContainer($options = array())
    {
        return new EmptyDocumentRepositoryContainer($options);
    }
}