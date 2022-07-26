<?php

namespace TinyBlocks\Vo;

use TinyBlocks\Vo\Internal\Exceptions\InvalidProperty;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeChanged;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeDeactivated;

/**
 * A Value Object is an immutable type that is only distinguishable by the state of its properties, that is,
 * unlike an entity, which has a unique identifier and remains distinct even if its properties are
 * identical, VOs with the same properties can be considered the same.
 *
 * @see http://martinfowler.com/bliki/ValueObject.html
 */
interface ValueObject
{
    /**
     * Returns object values.
     * @return array
     */
    public function values(): array;

    /**
     * Compare two ValueObjects, and tell if they are equal.
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other): bool;

    /**
     * Does not allow to get unknown property.
     * @param mixed $key
     * @return void
     * @throws InvalidProperty — Get unknown property.
     */
    public function __get(mixed $key): void;

    /**
     * Does not allow injection of unknown property.
     * @param mixed $key
     * @param mixed $value
     * @return void
     * @throws PropertyCannotBeChanged — If set property.
     */
    public function __set(mixed $key, mixed $value): void;

    /**
     * Does not allow properties to be disabled.
     * @param mixed $key
     * @return void
     * @throws PropertyCannotBeDeactivated — If disable property.
     */
    public function __unset(mixed $key): void;
}
