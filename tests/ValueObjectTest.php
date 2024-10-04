<?php

declare(strict_types=1);

namespace TinyBlocks\Vo;

use PHPUnit\Framework\TestCase;
use TinyBlocks\Vo\Internal\Exceptions\InvalidProperty;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeChanged;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeDeactivated;
use TinyBlocks\Vo\Models\Amount;
use TinyBlocks\Vo\Models\Order;
use TinyBlocks\Vo\Models\Product;

final class ValueObjectTest extends TestCase
{
    public function testValueObjectsAreEqual(): void
    {
        /** @Given two identical orders with the same ID and identical products */
        $productOne = new Product(name: 'Laptop', amount: new Amount(value: 100.0, currency: 'USD'));
        $productTwo = new Product(name: 'Mouse', amount: new Amount(value: 50.0, currency: 'USD'));

        $orderOne = new Order(id: 1, products: [$productOne, $productTwo]);
        $orderTwo = new Order(id: 1, products: [$productOne, $productTwo]);

        /** @When checking if both orders, with identical attributes, are equal */
        $actual = $orderOne->equals(other: $orderTwo);

        /** @Then the orders should be considered equal as all attributes match */
        self::assertTrue($actual);
    }

    public function testValueObjectsAreNotEqual(): void
    {
        /** @Given two orders with different products */
        $productOne = new Product(name: 'Laptop', amount: new Amount(value: 100.0, currency: 'USD'));
        $productTwo = new Product(name: 'Mouse', amount: new Amount(value: 50.0, currency: 'USD'));
        $productThree = new Product(name: 'Keyboard', amount: new Amount(value: 75.0, currency: 'USD'));

        $orderOne = new Order(id: 1, products: [$productOne, $productTwo]);
        $orderTwo = new Order(id: 1, products: [$productOne, $productThree]);

        /** @When checking if both orders, with different products, are not equal */
        $actual = $orderOne->equals(other: $orderTwo);

        /** @Then the orders should not be considered equal as products differ */
        self::assertFalse($actual);
    }

    public function testWhenInvalidProperty(): void
    {
        /** @Given an Order object */
        $order = new Order(id: 1);

        /** @When trying to access a non-existing property */
        /** @Then it should throw InvalidProperty exception */
        $template = 'Invalid property <%s> for class <%s>.';
        $this->expectException(InvalidProperty::class);
        $this->expectExceptionMessage(sprintf($template, 'nonExistentProperty', Order::class));
        $order->__get(key: 'nonExistentProperty');
    }

    public function testWhenPropertyCannotBeChanged(): void
    {
        /** @Given an Order object */
        $order = new Order(id: 1);

        /** @When trying to set a property */
        /** @Then it should throw PropertyCannotBeChanged exception */
        $template = 'Property <%s> cannot be changed in class <%s>.';
        $this->expectException(PropertyCannotBeChanged::class);
        $this->expectExceptionMessage(sprintf($template, 'id', Order::class));
        $order->__set(key: 'id', value: 2);
    }

    public function testWhenPropertyCannotBeDeactivated(): void
    {
        /** @Given an Order object */
        $order = new Order(id: 1);

        /** @When trying to unset a property */
        /** @Then it should throw PropertyCannotBeDeactivated exception */
        $template = 'Property <%s> cannot be deactivated in class <%s>.';
        $this->expectException(PropertyCannotBeDeactivated::class);
        $this->expectExceptionMessage(sprintf($template, 'id', Order::class));
        $order->__unset(key: 'id');
    }
}
