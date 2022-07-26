<?php

namespace TinyBlocks\Vo;

use PHPUnit\Framework\TestCase;
use stdClass;
use TinyBlocks\Vo\Internal\Exceptions\InvalidProperty;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeChanged;
use TinyBlocks\Vo\Internal\Exceptions\PropertyCannotBeDeactivated;
use TinyBlocks\Vo\Mock\SingleValueMock;

final class SingleValueTest extends TestCase
{
    public function testWhenEqualIsTrue(): void
    {
        $single = new SingleValueMock(id: 1);
        $other = new SingleValueMock(id: 1);

        $actual = $single->equals(other: $other);

        self::assertTrue($actual);
    }

    public function testWhenEqualIsFalse(): void
    {
        $single = new SingleValueMock(id: 1);
        $other = new SingleValueMock(id: 2);

        $actual = $single->equals(other: $other);

        self::assertFalse($actual);
    }

    public function testInvalidProperty(): void
    {
        $this->expectException(InvalidProperty::class);
        $this->expectErrorMessage('Invalid property <other> for class <TinyBlocks\Vo\Mock\SingleValueMock>.');

        $single = new SingleValueMock(id: 1);

        $single->__get('other');
    }

    public function testPropertyCannotBeChanged(): void
    {
        $this->expectException(PropertyCannotBeChanged::class);
        $this->expectErrorMessage('Property <other> cannot be changed in class <TinyBlocks\Vo\Mock\SingleValueMock>.');

        $single = new SingleValueMock(id: 1);

        $single->__set('other', new StdClass());
    }

    public function testPropertyCannotBeDeactivated(): void
    {
        $this->expectException(PropertyCannotBeDeactivated::class);
        $this->expectErrorMessage(
            'Property <other> cannot be deactivated in class <TinyBlocks\Vo\Mock\SingleValueMock>.'
        );

        $single = new SingleValueMock(id: 1);

        $single->__unset('other');
    }
}
