<?php

namespace Level3\Mongator\Mondator;

use Mandango\Mondator\Output;

class OutputFactory
{
    public function create($outputDirectory, $override)
    {
        return new Output($outputDirectory, $override);
    }
}