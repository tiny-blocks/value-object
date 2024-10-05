<?php

declare(strict_types=1);

namespace TinyBlocks\Vo;

use TinyBlocks\Immutable\Immutability;

trait ValueObjectBehavior
{
    use Immutability;

    public function equals(ValueObject $other): bool
    {
        return get_object_vars($this) == get_object_vars($other);
    }
}
