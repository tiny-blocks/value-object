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

The `equals` method compares two VOs by class and property values, returning `true` when both match.

```php
$transactionId = new TransactionId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');
$otherTransactionId = new TransactionId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');

$transactionId->equals(other: $otherTransactionId); # true
```

Equality is strict: two VOs of different classes with the same property values are **not** considered equal, even
when their shapes match.

```php
final readonly class OrderId implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(private string $value)
    {
    }
}

$transactionId = new TransactionId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');
$orderId = new OrderId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');

$transactionId->equals(other: $orderId); # false
```

<div id='faq'></div>

## FAQ

### 01. Why does `final readonly class` matter?

Declaring a VO as `final readonly class` makes immutability a language-level guarantee: the PHP runtime rejects
any attempt to mutate properties after construction, without requiring additional runtime checks. This is the
recommended form for all new VOs.

### 02. How is equality determined?

Two VOs are considered equal when they are instances of the same class and all their properties have the same
values, compared strictly. Different classes are never equal, even when their property shapes match.

<div id='license'></div>

## License

Value Object is licensed under [MIT](LICENSE).

<div id='contributing'></div>

## Contributing

Please follow the [contributing guidelines](https://github.com/tiny-blocks/tiny-blocks/blob/main/CONTRIBUTING.md) to
contribute to the project.
