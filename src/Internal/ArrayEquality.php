<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Internal;

final readonly class ArrayEquality
{
    public static function areEqual(array $left, array $right): bool
    {
        if (array_keys($left) !== array_keys($right)) {
            return false;
        }

        return array_all(
            $left,
            fn(mixed $element, int|string $key): bool => StructuralEquality::areEqual(
                left: $element,
                right: $right[$key]
            )
        );
    }
}
