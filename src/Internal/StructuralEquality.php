<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Internal;

use TinyBlocks\Vo\ValueObject;

final readonly class StructuralEquality
{
    public static function areEqual(mixed $left, mixed $right): bool
    {
        return match (true) {
            $left instanceof ValueObject
            && $right instanceof ValueObject => ValueObjectEquality::areEqual(left: $left, right: $right),
            is_array($left) && is_array($right)
                                             => ArrayEquality::areEqual(left: $left, right: $right),
            default
                                             => $left === $right
        };
    }
}
