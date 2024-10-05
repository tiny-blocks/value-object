<?php

declare(strict_types=1);

namespace TinyBlocks\Vo;

use TinyBlocks\Immutable\Immutable;

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
     * Compares this ValueObject with another to determine if they are equal.
     * Two ValueObjects are considered equal if their properties have the same values.
     *
     * @param ValueObject $other The ValueObject to compare with.
     * @return bool True if the objects are equal, false otherwise.
     */
    public function equals(ValueObject $other): bool;
}
