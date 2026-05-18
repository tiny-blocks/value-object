<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Internal;

use TinyBlocks\Vo\ValueObject;

final readonly class ValueObjectEquality
{
    public static function areEqual(ValueObject $left, ValueObject $right): bool
    {
        if ($left::class !== $right::class) {
            return false;
        }

        $rightProperties = get_object_vars($right);

        return array_all(
            get_object_vars($left),
            fn($element, $name) => StructuralEquality::areEqual(left: $element, right: $rightProperties[$name])
        );
    }
}
