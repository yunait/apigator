<?php

namespace Yunait\Apigator\Mondator;

use Mandango\Mondator\Output;

class OutputFactory
{
    public function create($outputDirectory, $override)
    {
        return new Output($outputDirectory, $override);
    }
}