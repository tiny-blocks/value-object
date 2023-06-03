<?php

namespace TinyBlocks\Vo;

use PHPUnit\Framework\TestCase;
use stdClass;
use TinyBlocks\Vo\Internal\Exceptions\InvalidProperty;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeChanged;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeDeactivated;
use TinyBlocks\Vo\Mock\AmountMock;
use TinyBlocks\Vo\Mock\ComplexValueMock;
use TinyBlocks\Vo\Mock\MultipleValueMock;
use TinyBlocks\Vo\Mock\SingleValueMock;
use TinyBlocks\Vo\Mock\TransactionMock;

final class ComplexValueTest extends TestCase
{
    public function testWhenEqualIsTrue(): void
    {
        $complex = new ComplexValueMock(
            single: new SingleValueMock(id: 1000),
            multiple: new MultipleValueMock(
                id: 999,
                transactions: [
                    new TransactionMock(id: 1, amount: new AmountMock(value: 0.99, currency: 'USD')),
                    new TransactionMock(id: 2, amount: new AmountMock(value: 10.55, currency: 'USD'))
                ]
            )
        );
        $other = new ComplexValueMock(
            single: new SingleValueMock(id: 1000),
            multiple: new MultipleValueMock(
                id: 999,
                transactions: [
                    new TransactionMock(id: 1, amount: new AmountMock(value: 0.99, currency: 'USD')),
                    new TransactionMock(id: 2, amount: new AmountMock(value: 10.55, currency: 'USD'))
                ]
            )
        );

        $actual = $complex->equals(other: $other);

        self::assertTrue($actual);
    }

    public function testWhenEqualIsFalse(): void
    {
        $complex = new ComplexValueMock(
            single: new SingleValueMock(id: 1000),
            multiple: new MultipleValueMock(
                id: 999,
                transactions: [
                    new TransactionMock(id: 1, amount: new AmountMock(value: 0.99, currency: 'USD')),
                    new TransactionMock(id: 2, amount: new AmountMock(value: 10.55, currency: 'USD'))
                ]
            )
        );
        $other = new ComplexValueMock(
            single: new SingleValueMock(id: 1000),
            multiple: new MultipleValueMock(
                id: 999,
                transactions: [
                    new TransactionMock(id: 1, amount: new AmountMock(value: 0.99, currency: 'USD')),
                    new TransactionMock(id: 2, amount: new AmountMock(value: 10.56, currency: 'USD'))
                ]
            )
        );

        $actual = $complex->equals(other: $other);

        self::assertFalse($actual);
    }

    public function testInvalidProperty(): void
    {
        $this->expectException(InvalidProperty::class);
        $this->expectExceptionMessage('Invalid property <other> for class <TinyBlocks\Vo\Mock\ComplexValueMock>.');

        $complex = new ComplexValueMock(
            single: new SingleValueMock(id: 1000),
            multiple: new MultipleValueMock(
                id: 999,
                transactions: [
                    new TransactionMock(id: 1, amount: new AmountMock(value: 0.99, currency: 'USD')),
                    new TransactionMock(id: 2, amount: new AmountMock(value: 10.55, currency: 'USD'))
                ]
            )
        );
        $complex->__get(key: 'other');
    }

    public function testPropertyCannotBeChanged(): void
    {
        $this->expectException(PropertyCannotBeChanged::class);
        $this->expectExceptionMessage(
            'Property <other> cannot be changed in class <TinyBlocks\Vo\Mock\ComplexValueMock>.'
        );

        $complex = new ComplexValueMock(
            single: new SingleValueMock(id: 1000),
            multiple: new MultipleValueMock(
                id: 999,
                transactions: [
                    new TransactionMock(id: 1, amount: new AmountMock(value: 0.99, currency: 'USD')),
                    new TransactionMock(id: 2, amount: new AmountMock(value: 10.55, currency: 'USD'))
                ]
            )
        );
        $complex->__set(key: 'other', value: new StdClass());
    }

    public function testPropertyCannotBeDeactivated(): void
    {
        $this->expectException(PropertyCannotBeDeactivated::class);
        $this->expectExceptionMessage(
            'Property <other> cannot be deactivated in class <TinyBlocks\Vo\Mock\ComplexValueMock>.'
        );

        $complex = new ComplexValueMock(
            single: new SingleValueMock(id: 1000),
            multiple: new MultipleValueMock(
                id: 999,
                transactions: [
                    new TransactionMock(id: 1, amount: new AmountMock(value: 0.99, currency: 'USD')),
                    new TransactionMock(id: 2, amount: new AmountMock(value: 10.55, currency: 'USD'))
                ]
            )
        );
        $complex->__unset(key: 'other');
    }
}
