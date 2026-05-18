<?php

declare(strict_types=1);

namespace TinyBlocks\Vo;

/**
 * A Value Object is an immutable type that is only distinguishable by the state of its properties, that is,
 * unlike an entity, which has a unique identifier and remains distinct even if its properties are
 * identical, VOs with the same properties can be considered the same.
 *
 * <p>Recommended usage: declare implementations as <code>readonly class</code> (PHP 8.2+) to enforce the
 * immutability contract at the language level. Mutable properties violate Value Object semantics even when
 * <code>equals</code> and <code>hashCode</code> still function. Properties must be declared
 * <code>public</code>; non-public properties are invisible to the equality and hashing engine.</p>
 *
 * @see http://martinfowler.com/bliki/ValueObject.html
 */
interface ValueObject
{
    /**
     * Tells whether this Value Object holds the same state as another.
     *
     * <p>Equality is structural and recursive. Two Value Objects are equal when they share the same concrete
     * class and every paired property is equal: scalars compare by value, nested
     * <code>{@see ValueObject}</code> properties delegate to their own <code>equals</code>, arrays compare
     * by keys in the same order with values compared recursively, and enums compare by case identity.</p>
     *
     * <p>Properties holding objects that are not Value Objects (for example, <code>DateTimeImmutable</code>)
     * are compared by instance identity. Wrap such values in a dedicated Value Object when value semantics
     * are desired.</p>
     *
     * @param ValueObject $other The Value Object to compare against.
     * @return bool True when both Value Objects hold the same structural state, false otherwise.
     */
    public function equals(ValueObject $other): bool;

    /**
     * Returns a deterministic hash derived from the Value Object's structural state.
     *
     * <p>The contract pairs with <code>{@see ValueObject::equals}</code>: when <code>$a->equals($b)</code>
     * holds, <code>$a->hashCode() === $b->hashCode()</code> also holds. Repeated calls on the same instance
     * return the same hash within a single process. Stability across library versions is not guaranteed.</p>
     *
     * @return string The structural hash of this Value Object.
     */
    public function hashCode(): string;
}
