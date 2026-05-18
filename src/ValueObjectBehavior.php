<?php

declare(strict_types=1);

namespace TinyBlocks\Vo;

use TinyBlocks\Vo\Internal\StructuralEquality;
use TinyBlocks\Vo\Internal\StructuralHash;

trait ValueObjectBehavior
{
    public function equals(ValueObject $other): bool
    {
        return StructuralEquality::areEqual(left: $this, right: $other);
    }

    public function hashCode(): string
    {
        return StructuralHash::hash(subject: $this);
    }
}
