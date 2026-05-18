<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Models;

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final readonly class Invoice implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(public Money $total, public int $number)
    {
    }
}
