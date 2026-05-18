# Value Object

[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

* [Overview](#overview)
* [Installation](#installation)
* [How to use](#how-to-use)
    + [Declaring a Value Object](#declaring-a-value-object)
    + [Comparing with equals](#comparing-with-equals)
    + [Hashing with hashCode](#hashing-with-hashcode)
    + [Behavior with nested types](#behavior-with-nested-types)
* [FAQ](#faq)
* [License](#license)
* [Contributing](#contributing)

## Overview

A **V**alue **O**bject (**VO**) is a type that is distinguishable only by the state of its properties. Unlike an
entity, which has a unique identifier and remains distinct even if its properties are identical, VOs with the same
properties are considered equal.

This library exposes the `ValueObject` interface, which defines structural equality through `equals()` and a
deterministic hash through `hashCode()`, and the `ValueObjectBehavior` trait, which provides the default recursive
implementation for both operations.

More details about [VOs](https://martinfowler.com/bliki/ValueObject.html).

## Installation

```bash
composer require tiny-blocks/value-object
```

## How to use

### Declaring a Value Object

Declare your VO as `readonly class` (PHP 8.2+) so that PHP enforces immutability at the language level. Mutable
properties violate Value Object semantics even when `equals` and `hashCode` still function.

Implementations must declare properties as `public`. Non-public properties are not seen by the equality and
hashing engine, because comparison and hashing run from outside the implementing class.

```php
<?php

declare(strict_types=1);

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final readonly class TransactionId implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(public string $value)
    {
    }
}
```

### Comparing with equals

The `equals` method compares two VOs structurally and recursively. Two VOs are equal when they share the same
concrete class and every paired property is equal.

```php
<?php

declare(strict_types=1);

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final readonly class TransactionId implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(public string $value)
    {
    }
}

$transactionId = new TransactionId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');
$otherTransactionId = new TransactionId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');

# true
$transactionId->equals(other: $otherTransactionId);
```

Equality is strict: two VOs of different classes with the same property values are **not** considered equal, even
when their shapes match.

### Hashing with hashCode

The `hashCode` method returns a deterministic hash derived from the VO's structural state. The contract pairs with
`equals`: when `$a->equals($b)` holds, `$a->hashCode() === $b->hashCode()` also holds. Repeated calls on the same
instance return the same hash within a single process.

```php
<?php

declare(strict_types=1);

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final readonly class TransactionId implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(public string $value)
    {
    }
}

$transactionId = new TransactionId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');
$otherTransactionId = new TransactionId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');

# true
$transactionId->hashCode() === $otherTransactionId->hashCode();
```

<div id='behavior-with-nested-types'></div>

### Behavior with nested types

Comparison and hashing traverse properties recursively. The behavior for each property kind follows the table below.

| Property kind                            | Compared by                                                                          |
|------------------------------------------|--------------------------------------------------------------------------------------|
| Scalars (`bool`, `int`, ...)             | Strict value (`===`).                                                                |
| `null`.                                  | Strict identity (`===`).                                                             |
| Nested `ValueObject`.                    | Recursive `equals` and `hashCode`. Distinct instances with the same state are equal. |
| Arrays.                                  | Same keys in the same order with values compared recursively.                        |
| `BackedEnum` and `UnitEnum`.             | Case identity. Enums are singletons in PHP, so the same case shares the same hash.   |
| Other objects (`DateTimeImmutable`, ...) | Instance identity. Distinct instances with the same state are **not** equal.         |

For external objects such as `DateTimeImmutable`, comparison falls back to instance identity. Wrap them in a
dedicated Value Object when value semantics are desired:

```php
<?php

declare(strict_types=1);

use DateTimeImmutable;
use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final readonly class Moment implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(public string $iso8601)
    {
    }

    public static function from(DateTimeImmutable $instant): Moment
    {
        return new Moment(iso8601: $instant->format(DateTimeImmutable::ATOM));
    }
}
```

## FAQ

### 01. Why does `readonly class` matter?

Declaring a VO as `readonly class` makes immutability a language-level guarantee: the PHP runtime rejects any
attempt to mutate properties after construction, without requiring additional runtime checks. This is the
recommended form for all new VOs.

### 02. How is equality determined?

Two VOs are equal when they share the same concrete class and every paired property is equal. The comparison is
recursive: nested Value Objects delegate to their own `equals`, arrays compare by keys in the same order with
values compared recursively, and enums compare by case identity. Properties holding objects that are not Value
Objects (for example, `DateTimeImmutable`) are compared by instance identity.

### 03. Is the hash stable across versions?

The hash is deterministic within a single process and consistent with `equals`: equal objects share the same hash.
Stability across library versions is not guaranteed and should not be relied upon for persistence.

## License

Value Object is licensed under [MIT](LICENSE).

## Contributing

Please follow the [contributing guidelines](https://github.com/tiny-blocks/tiny-blocks/blob/main/CONTRIBUTING.md) to
contribute to the project.
