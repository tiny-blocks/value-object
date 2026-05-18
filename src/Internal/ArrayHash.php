<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Internal;

final readonly class ArrayHash
{
    public static function hash(array $subject): string
    {
        $serialized = '[';

        foreach ($subject as $key => $element) {
            $serialized = sprintf('%s%s=%s;', $serialized, $key, StructuralHash::hash(subject: $element));
        }

        return sprintf('%s]', $serialized);
    }
}
