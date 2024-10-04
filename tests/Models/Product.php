<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Models;

final readonly class Product
{
    public function __construct(public string $name, public Amount $amount)
    {

    }
}
