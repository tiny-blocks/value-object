<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Models;

use DateTimeImmutable;
use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final readonly class Period implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(public DateTimeImmutable $startAt, public DateTimeImmutable $endAt)
    {
    }
}
