<?php

declare(strict_types=1);

namespace TinyBlocks\Vo;

use TinyBlocks\Vo\Internal\Exceptions\InvalidProperty;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeChanged;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeDeactivated;

/**
 * Defines immutability by restricting property modification.
 */
interface Immutable
{
    /**
     * Does not allow to get unknown property.
     * @param mixed $key
     * @return void
     * @throws InvalidProperty Get unknown property.
     */
    public function __get(mixed $key): void;

    /**
     * Does not allow injection of unknown property.
     * @param mixed $key
     * @param mixed $value
     * @return void
     * @throws PropertyCannotBeChanged If set property.
     */
    public function __set(mixed $key, mixed $value): void;

    /**
     * Does not allow properties to be disabled.
     * @param mixed $key
     * @return void
     * @throws PropertyCannotBeDeactivated If disable property.
     */
    public function __unset(mixed $key): void;
}
