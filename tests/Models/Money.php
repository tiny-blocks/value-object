<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Models;

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final readonly class Money implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(public int $amount, public Currency $currency)
    {
    }
}
