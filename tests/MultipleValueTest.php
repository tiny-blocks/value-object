<?php

namespace TinyBlocks\Vo;

use PHPUnit\Framework\TestCase;
use stdClass;
use TinyBlocks\Vo\Internal\Exceptions\InvalidProperty;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeChanged;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeDeactivated;
use TinyBlocks\Vo\Mock\AmountMock;
use TinyBlocks\Vo\Mock\MultipleValueMock;
use TinyBlocks\Vo\Mock\TransactionMock;

final class MultipleValueTest extends TestCase
{
    public function testWhenEqualIsTrue(): void
    {
        $multiple = new MultipleValueMock(
            id: 123,
            transactions: [
                new TransactionMock(id: 100, amount: new AmountMock(value: 10.0, currency: 'BRL')),
                new TransactionMock(id: 200, amount: new AmountMock(value: 11.01, currency: 'BRL'))
            ]
        );
        $other = new MultipleValueMock(
            id: 123,
            transactions: [
                new TransactionMock(id: 100, amount: new AmountMock(value: 10.0, currency: 'BRL')),
                new TransactionMock(id: 200, amount: new AmountMock(value: 11.01, currency: 'BRL'))
            ]
        );

        $actual = $multiple->equals(other: $other);

        self::assertTrue($actual);
    }

    public function testWhenEqualIsFalse(): void
    {
        $multiple = new MultipleValueMock(
            id: 123,
            transactions: [
                new TransactionMock(id: 100, amount: new AmountMock(value: 10.0, currency: 'BRL')),
                new TransactionMock(id: 200, amount: new AmountMock(value: 11.01, currency: 'BRL'))
            ]
        );
        $other = new MultipleValueMock(
            id: 123,
            transactions: [
                new TransactionMock(id: 100, amount: new AmountMock(value: 10.0, currency: 'USD')),
                new TransactionMock(id: 200, amount: new AmountMock(value: 11.01, currency: 'USD'))
            ]
        );

        $actual = $multiple->equals(other: $other);

        self::assertFalse($actual);
    }

    public function testInvalidProperty(): void
    {
        $this->expectException(InvalidProperty::class);
        $this->expectErrorMessage('Invalid property <other> for class <TinyBlocks\Vo\Mock\MultipleValueMock>.');

        $multiple = new MultipleValueMock(
            id: 123,
            transactions: [
                new TransactionMock(id: 100, amount: new AmountMock(value: 10.0, currency: 'BRL')),
                new TransactionMock(id: 200, amount: new AmountMock(value: 11.01, currency: 'BRL'))
            ]
        );
        $multiple->__get('other');
    }

    public function testPropertyCannotBeChanged(): void
    {
        $this->expectException(PropertyCannotBeChanged::class);
        $this->expectErrorMessage(
            'Property <other> cannot be changed in class <TinyBlocks\Vo\Mock\MultipleValueMock>.'
        );

        $multiple = new MultipleValueMock(
            id: 123,
            transactions: [
                new TransactionMock(id: 100, amount: new AmountMock(value: 10.0, currency: 'BRL')),
                new TransactionMock(id: 200, amount: new AmountMock(value: 11.01, currency: 'BRL'))
            ]
        );
        $multiple->__set('other', new StdClass());
    }

    public function testPropertyCannotBeDeactivated(): void
    {
        $this->expectException(PropertyCannotBeDeactivated::class);
        $this->expectErrorMessage(
            'Property <other> cannot be deactivated in class <TinyBlocks\Vo\Mock\MultipleValueMock>.'
        );

        $multiple = new MultipleValueMock(
            id: 123,
            transactions: [
                new TransactionMock(id: 100, amount: new AmountMock(value: 10.0, currency: 'BRL')),
                new TransactionMock(id: 200, amount: new AmountMock(value: 11.01, currency: 'BRL'))
            ]
        );
        $multiple->__unset('other');
    }
}
