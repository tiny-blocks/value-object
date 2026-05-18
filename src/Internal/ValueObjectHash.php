<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Internal;

use TinyBlocks\Vo\ValueObject;

final readonly class ValueObjectHash
{
    public static function hash(ValueObject $subject): string
    {
        $serialized = $subject::class;

        foreach (get_object_vars($subject) as $name => $element) {
            $serialized = sprintf('%s|%s=%s', $serialized, $name, StructuralHash::hash(subject: $element));
        }

        return hash('xxh128', $serialized);
    }
}
