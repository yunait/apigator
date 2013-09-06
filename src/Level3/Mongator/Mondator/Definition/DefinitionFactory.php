<?php

namespace Level3\Mongator\Mondator\Definition;

use Mandango\Mondator\Definition;
use Mandango\Mondator\Output;

class DefinitionFactory
{
    public function create($class, Output $output)
    {
        return new Definition($class, $output);
    }
}
