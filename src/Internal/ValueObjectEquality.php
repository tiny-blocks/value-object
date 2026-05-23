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

        $rightProperties = ObjectProperties::extract(subject: $right);

        return array_all(
            ObjectProperties::extract(subject: $left),
            fn(mixed $element, string $name): bool => StructuralEquality::areEqual(
                left: $element,
                right: $rightProperties[$name]
            )
        );
    }
}
