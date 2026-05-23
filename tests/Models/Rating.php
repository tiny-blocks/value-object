<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Models;

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final class Rating implements ValueObject
{
    use ValueObjectBehavior;

    private static int $ratingCount = 0;

    public function __construct(public readonly int $score)
    {
        self::$ratingCount++;
    }
}
