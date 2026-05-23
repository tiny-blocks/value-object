<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Internal;

use TinyBlocks\Vo\ValueObject;

final readonly class ValueObjectHash
{
    public static function hash(ValueObject $subject): string
    {
        $serialized = $subject::class;

        foreach (ObjectProperties::extract(subject: $subject) as $name => $element) {
            $template = '%s|%s=%s';
            $serialized = sprintf($template, $serialized, $name, StructuralHash::hash(subject: $element));
        }

        return hash('xxh128', $serialized);
    }
}
