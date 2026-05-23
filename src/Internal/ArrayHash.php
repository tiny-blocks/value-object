<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Internal;

final readonly class ArrayHash
{
    public static function hash(array $subject): string
    {
        $serialized = '[';

        foreach ($subject as $key => $element) {
            $template = '%s%s=%s;';
            $serialized = sprintf($template, $serialized, $key, StructuralHash::hash(subject: $element));
        }

        $template = '%s]';

        return sprintf($template, $serialized);
    }
}
