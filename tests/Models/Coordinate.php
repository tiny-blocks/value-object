<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Models;

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final readonly class Coordinate implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(public float $latitude, public float $longitude)
    {
    }
}
