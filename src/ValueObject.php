<?php

declare(strict_types=1);

namespace TinyBlocks\Vo;

/**
 * A Value Object is an immutable type that is only distinguishable by the state of its properties, that is,
 * unlike an entity, which has a unique identifier and remains distinct even if its properties are
 * identical, VOs with the same properties can be considered the same.
 *
 * @see http://martinfowler.com/bliki/ValueObject.html
 */
interface ValueObject extends Immutable
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
}
