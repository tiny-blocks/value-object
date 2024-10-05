<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Models;

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final readonly class Order implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(public int $id, public iterable $products = [])
    {
    }
}
