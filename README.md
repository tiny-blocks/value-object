# Value Object

[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

* [Overview](#overview)
* [Installation](#installation)
* [How to use](#how-to-use)
* [FAQ](#faq)
* [License](#license)
* [Contributing](#contributing)

<div id='overview'></div>

## Overview

A **V**alue **O**bject (**VO**) is a type that is distinguishable only by the state of its properties. Unlike an
entity, which has a unique identifier and remains distinct even if its properties are identical, VOs with the same
properties are considered equal.

Immutability is an expectation for VOs, not a contract enforced by this interface. The recommended way to enforce
it is to declare implementing classes as `final readonly class`, which PHP enforces at the language level. If you
need runtime enforcement (e.g., for classes that cannot be `readonly`), you can explicitly compose
`TinyBlocks\Immutable\Immutable` alongside `ValueObject`.

More details about [VOs](https://martinfowler.com/bliki/ValueObject.html).

<div id='installation'></div>

## Installation

```bash
composer require tiny-blocks/value-object
```

<div id='how-to-use'></div>

## How to use

The library exposes the `ValueObject` interface, which defines structural equality via `equals()`, and the
`ValueObjectBehavior` trait, which provides a default implementation.

### Concrete implementation

Declare your VO as `final readonly class` to let PHP enforce immutability at the language level.

```php
<?php

namespace Example;

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final readonly class TransactionId implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(private string $value)
    {
    }
}
```

### Using the equals method

The `equals` method compares the value of two VOs and checks if they are equal.

```php
$transactionId = new TransactionId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');
$otherTransactionId = new TransactionId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');

$transactionId->equals(other: $otherTransactionId); # true
```

### Composing with runtime immutability enforcement

If your VO cannot be `readonly` (e.g., it extends a mutable base class), combine both interfaces explicitly:

```php
<?php

namespace Example;

use TinyBlocks\Immutable\Immutable;
use TinyBlocks\Immutable\Immutability;
use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final class LegacyAmount implements ValueObject, Immutable
{
    use ValueObjectBehavior;
    use Immutability;

    public function __construct(private readonly float $value)
    {
    }
}
```

<div id='faq'></div>

## FAQ

### 01. Why does `ValueObject` no longer extend `Immutable`?

Prior to version 4.0, `ValueObject` extended `TinyBlocks\Immutable\Immutable`, forcing every VO to carry
`__set`, `__unset`, `offsetSet`, and `offsetUnset` guards even when they were not needed. Since `final readonly
class` enforces immutability at the language level for the vast majority of VOs, the runtime enforcement became
unnecessary overhead and an unwanted coupling. Consumers that need runtime enforcement can compose both interfaces
explicitly, as shown in the example above.

<div id='license'></div>

## License

Value Object is licensed under [MIT](LICENSE).

<div id='contributing'></div>

## Contributing

Please follow the [contributing guidelines](https://github.com/tiny-blocks/tiny-blocks/blob/main/CONTRIBUTING.md) to
contribute to the project.
