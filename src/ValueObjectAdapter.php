<?php

namespace TinyBlocks\Vo;

use TinyBlocks\Vo\Internal\Exceptions\InvalidProperty;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeChanged;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeDeactivated;

trait ValueObjectAdapter
{
    public function values(): array
    {
        return get_object_vars($this);
    }

    public function equals(ValueObject $other): bool
    {
        return $this->values() == $other->values();
    }

    public function __get(mixed $key): void
    {
        if (!property_exists($this, $key)) {
            throw new InvalidProperty(key: $key, class: get_called_class());
        }
    }

    public function __set(mixed $key, mixed $value): void
    {
        throw new PropertyCannotBeChanged(key: $key, class: get_called_class());
    }

    public function __unset(mixed $key): void
    {
        throw new PropertyCannotBeDeactivated(key: $key, class: get_called_class());
    }
}
