<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Internal;

use ReflectionObject;

final readonly class ObjectProperties
{
    public static function extract(object $subject): array
    {
        $reflection = new ReflectionObject(object: $subject);
        $properties = [];

        foreach ($reflection->getProperties() as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $properties[$property->getName()] = $property->getValue(object: $subject);
        }

        return $properties;
    }
}
