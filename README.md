# Value Object

[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

* [Overview](#overview)
* [Installation](#installation)
* [How to use](#how-to-use)
* [License](#license)
* [Contributing](#contributing)

<div id='overview'></div> 

## Overview

A **V**alue **O**bject (**VO**) is an immutable type that is only distinguishable by the state of its properties, that
is, unlike an entity, which has a unique identifier and remains distinct even if its properties are identical, VOs with
the same properties can be considered the same.

Because they are immutable, VOs cannot be changed once created. Modifying one is conceptually the same as discard the
old one and create a new one.

More details about [VOs](https://martinfowler.com/bliki/ValueObject.html).

<div id='installation'></div>

## Installation

```bash
composer require tiny-blocks/value-object
```

<div id='how-to-use'></div>

## How to use

The library exposes available behaviors through the `ValueObject` interface, and the implementation of these behaviors
through the `ValueObjectAdapter` trait.

### Concrete implementation

With the implementation of the `ValueObject` interface, and the `ValueObjectAdapter` trait, the use of
`__get`, `__set` and `__unset` methods is suppressed, making the object immutable.

```php
<?php

namespace Example;

use TinyBlocks\Vo\ValueObject;
use TinyBlocks\Vo\ValueObjectBehavior;

final class TransactionId implements ValueObject
{
    use ValueObjectBehavior;

    public function __construct(private readonly string $value)
    {
    }
}
```

### Using the equals method

The `equals` method compares the value of two VOs, and checks if they are equal.

```php
$transactionId = new TransactionId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');
$otherTransactionId = new TransactionId(value: 'e6e2442f-3bd8-421f-9ac2-f9e26ac4abd2');

$transactionId->equals(other: $otherTransactionId); # true
```

<div id='license'></div>

## License

Value Object is licensed under [MIT](LICENSE).

<div id='contributing'></div>

## Contributing

Please follow the [contributing guidelines](https://github.com/tiny-blocks/tiny-blocks/blob/main/CONTRIBUTING.md) to
contribute to the project.
