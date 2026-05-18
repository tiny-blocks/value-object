<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Internal;

use TinyBlocks\Vo\ValueObject;

final readonly class StructuralHash
{
    public static function hash(mixed $subject): string
    {
        return match (true) {
            is_null($subject), is_scalar($subject) => var_export($subject, true),
            $subject instanceof ValueObject        => ValueObjectHash::hash(subject: $subject),
            is_array($subject)                     => ArrayHash::hash(subject: $subject),
            default                                => spl_object_hash((object) $subject)
        };
    }
}
