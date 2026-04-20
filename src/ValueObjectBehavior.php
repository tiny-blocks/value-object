<?php

declare(strict_types=1);

namespace TinyBlocks\Vo;

trait ValueObjectBehavior
{
    public function equals(ValueObject $other): bool
    {
        return $other::class === static::class
            && get_object_vars($this) === get_object_vars($other);
    }
}
