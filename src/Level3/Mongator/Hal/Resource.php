<?php
/*
 * This file is part of the Level3 package.
 *
 * (c) Máximo Cuadros <maximo@yunait.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Level3\Mongator\Hal;
use Level3\Hal\Resource as BaseResouce;

use Level3\Hal\Formatter\Formatter;

abstract class Resource extends BaseResouce
{
    abstract public function toResponse(ResourceBuilder $builder, AbstractDocument $document);
    abstract public function fromRequest(Array $data);
}
