<?php

namespace Level3\Mongator\Mondator\Extension;

class ExtensionFactory
{
    public function createExtensions($options = array())
    {
        return array(
            $this->createResourceExtension($options),
            $this->createEmptyResourceExtension($options),
            $this->createResourceFormatterExtension($options),
            $this->createEmptyResourceFormatterExtension($options),
        );
    }

    protected function createResourceExtension($options = array())
    {
        return new ResourceExtension($options);
    }

    protected function createEmptyResourceExtension($options = array())
    {
        return new EmptyResourceExtension($options);
    }

    protected function createResourceFormatterExtension($options = array())
    {
        return new ResourceFormatterExtension($options);
    }

    protected function createEmptyResourceFormatterExtension($options = array())
    {
        return new EmptyResourceFormatterExtension($options);
    }
}
