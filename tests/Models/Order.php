<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Models;

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectAdapter;

final readonly class Order implements ValueObject
{
    use ValueObjectAdapter;

    public function __construct(public int $id, public iterable $products = [])
    {
    }
}
