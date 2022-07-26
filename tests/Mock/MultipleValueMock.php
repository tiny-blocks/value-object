<?php

namespace TinyBlocks\Vo\Mock;

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectAdapter;

final class MultipleValueMock implements ValueObject
{
    use ValueObjectAdapter;

    public function __construct(private readonly int $id, private readonly array $transactions)
    {
    }
}
