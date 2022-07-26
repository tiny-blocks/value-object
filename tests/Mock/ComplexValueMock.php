<?php

namespace TinyBlocks\Vo\Mock;

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectAdapter;

final class ComplexValueMock implements ValueObject
{
    use ValueObjectAdapter;

    public function __construct(private readonly SingleValueMock $single, private readonly MultipleValueMock $multiple)
    {
    }
}
