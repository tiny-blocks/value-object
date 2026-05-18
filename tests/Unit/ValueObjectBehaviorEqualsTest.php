<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Unit;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use TinyBlocks\Vo\Models\Coordinate;
use TinyBlocks\Vo\Models\Currency;
use TinyBlocks\Vo\Models\Invoice;
use TinyBlocks\Vo\Models\Money;
use TinyBlocks\Vo\Models\Order;
use TinyBlocks\Vo\Models\Period;
use TinyBlocks\Vo\Models\Point;
use TinyBlocks\Vo\Models\Profile;

final class ValueObjectBehaviorEqualsTest extends TestCase
{
    public function testEqualsWhenInvokedOnSameInstanceThenReturnsTrue(): void
    {
        /** @Given a Money instance */
        $money = new Money(amount: 10, currency: Currency::EUR);

        /** @When comparing the instance against itself */
        $areEqual = $money->equals(other: $money);

        /** @Then the result is true */
        self::assertTrue($areEqual);
    }

    public function testEqualsWhenSameClassAndAllScalarsMatchThenReturnsTrue(): void
    {
        /** @Given a Money instance priced in BRL */
        $left = new Money(amount: 100, currency: Currency::BRL);

        /** @And another Money instance with identical scalar state */
        $right = new Money(amount: 100, currency: Currency::BRL);

        /** @When comparing both instances */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is true */
        self::assertTrue($areEqual);
    }

    public function testEqualsWhenScalarPropertyDiffersThenReturnsFalse(): void
    {
        /** @Given a Money instance for one hundred BRL */
        $left = new Money(amount: 100, currency: Currency::BRL);

        /** @And another Money instance with a different amount */
        $right = new Money(amount: 200, currency: Currency::BRL);

        /** @When comparing both instances */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is false */
        self::assertFalse($areEqual);
    }

    public function testEqualsWhenDifferentClassesShareSameShapeThenReturnsFalse(): void
    {
        /** @Given a Coordinate instance */
        $coordinate = new Coordinate(latitude: 1.0, longitude: 2.0);

        /** @And a Point instance with identical scalar state */
        $point = new Point(latitude: 1.0, longitude: 2.0);

        /** @When comparing values of different classes */
        $areEqual = $coordinate->equals(other: $point);

        /** @Then the result is false */
        self::assertFalse($areEqual);
    }

    public function testEqualsWhenBothNullablePropertiesAreNullThenReturnsTrue(): void
    {
        /** @Given a Profile without a nickname */
        $left = new Profile(name: 'Ada', nickname: null);

        /** @And another Profile without a nickname */
        $right = new Profile(name: 'Ada', nickname: null);

        /** @When comparing both instances */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is true */
        self::assertTrue($areEqual);
    }

    public function testEqualsWhenOnlyOneNullablePropertyIsNullThenReturnsFalse(): void
    {
        /** @Given a Profile without a nickname */
        $left = new Profile(name: 'Ada', nickname: null);

        /** @And another Profile carrying a nickname */
        $right = new Profile(name: 'Ada', nickname: 'Lovelace');

        /** @When comparing both instances */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is false */
        self::assertFalse($areEqual);
    }

    public function testEqualsWhenNestedValueObjectsAreDistinctInstancesWithSameStateThenReturnsTrue(): void
    {
        /** @Given an Invoice with a Money total */
        $left = new Invoice(total: new Money(amount: 500, currency: Currency::USD), number: 1);

        /** @And another Invoice with a distinct Money instance carrying the same state */
        $right = new Invoice(total: new Money(amount: 500, currency: Currency::USD), number: 1);

        /** @When comparing both invoices */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is true */
        self::assertTrue($areEqual);
    }

    public function testEqualsWhenNestedValueObjectsCarryDifferentStateThenReturnsFalse(): void
    {
        /** @Given an Invoice totaling five hundred USD */
        $left = new Invoice(total: new Money(amount: 500, currency: Currency::USD), number: 1);

        /** @And another Invoice totaling seven hundred and fifty USD */
        $right = new Invoice(total: new Money(amount: 750, currency: Currency::USD), number: 1);

        /** @When comparing both invoices */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is false */
        self::assertFalse($areEqual);
    }

    public function testEqualsWhenScalarArraysShareSameElementsInSameOrderThenReturnsTrue(): void
    {
        /** @Given an Order with a list of scalar items */
        $left = new Order(items: [10, 20, 30], number: 1);

        /** @And another Order with the same scalars in the same order */
        $right = new Order(items: [10, 20, 30], number: 1);

        /** @When comparing both orders */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is true */
        self::assertTrue($areEqual);
    }

    public function testEqualsWhenScalarArraysShareElementsInDifferentOrderThenReturnsFalse(): void
    {
        /** @Given an Order with scalar items in ascending order */
        $left = new Order(items: [10, 20, 30], number: 1);

        /** @And another Order with the same scalars in descending order */
        $right = new Order(items: [30, 20, 10], number: 1);

        /** @When comparing both orders */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is false */
        self::assertFalse($areEqual);
    }

    public function testEqualsWhenArraysOfNestedValueObjectsHaveSameStateThenReturnsTrue(): void
    {
        /** @Given an Order containing two distinct Money instances */
        $left = new Order(
            items: [
                new Money(amount: 100, currency: Currency::BRL),
                new Money(amount: 200, currency: Currency::USD)
            ],
            number: 1
        );

        /** @And another Order with separately constructed Money instances matching the same state */
        $right = new Order(
            items: [
                new Money(amount: 100, currency: Currency::BRL),
                new Money(amount: 200, currency: Currency::USD)
            ],
            number: 1
        );

        /** @When comparing both orders */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is true */
        self::assertTrue($areEqual);
    }

    public function testEqualsWhenAssociativeArraysShareSameEntriesThenReturnsTrue(): void
    {
        /** @Given an Order indexed by SKU */
        $left = new Order(items: ['sku-a' => 1, 'sku-b' => 2], number: 1);

        /** @And another Order with the same SKU keys and values */
        $right = new Order(items: ['sku-a' => 1, 'sku-b' => 2], number: 1);

        /** @When comparing both orders */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is true */
        self::assertTrue($areEqual);
    }

    public function testEqualsWhenAssociativeArrayHasExtraKeyOnOneSideThenReturnsFalse(): void
    {
        /** @Given an Order with two SKU entries */
        $left = new Order(items: ['sku-a' => 1, 'sku-b' => 2], number: 1);

        /** @And another Order with an additional SKU entry */
        $right = new Order(items: ['sku-a' => 1, 'sku-b' => 2, 'sku-c' => 3], number: 1);

        /** @When comparing both orders */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is false */
        self::assertFalse($areEqual);
    }

    public function testEqualsWhenBackedEnumPropertiesShareSameCaseThenReturnsTrue(): void
    {
        /** @Given a Money instance priced in USD */
        $left = new Money(amount: 50, currency: Currency::USD);

        /** @And another Money instance priced in USD */
        $right = new Money(amount: 50, currency: Currency::USD);

        /** @When comparing both instances */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is true */
        self::assertTrue($areEqual);
    }

    public function testEqualsWhenExternalObjectInstanceIsSharedThenReturnsTrue(): void
    {
        /** @Given a shared DateTimeImmutable instance */
        $moment = new DateTimeImmutable('2026-01-01T00:00:00+00:00');

        /** @And a Period spanning that moment */
        $left = new Period(startAt: $moment, endAt: $moment);

        /** @And another Period sharing the same DateTimeImmutable instance */
        $right = new Period(startAt: $moment, endAt: $moment);

        /** @When comparing both periods */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is true */
        self::assertTrue($areEqual);
    }

    public function testEqualsWhenExternalObjectsAreDistinctInstancesEvenWithSameStateThenReturnsFalse(): void
    {
        /** @Given a Period built from one pair of DateTimeImmutable instances */
        $left = new Period(
            startAt: new DateTimeImmutable('2026-01-01T00:00:00+00:00'),
            endAt: new DateTimeImmutable('2026-12-31T23:59:59+00:00')
        );

        /** @And another Period built from separate DateTimeImmutable instances with the same timestamps */
        $right = new Period(
            startAt: new DateTimeImmutable('2026-01-01T00:00:00+00:00'),
            endAt: new DateTimeImmutable('2026-12-31T23:59:59+00:00')
        );

        /** @When comparing both periods */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is false */
        self::assertFalse($areEqual);
    }

    public function testEqualsWhenArrayElementsMixValueObjectsAndArraysThenReturnsFalse(): void
    {
        /** @Given an Order whose first item is a Money value object */
        $left = new Order(items: [new Money(amount: 1, currency: Currency::BRL)], number: 1);

        /** @And another Order whose first item is an array carrying the same shape */
        $right = new Order(items: [['amount' => 1, 'currency' => Currency::BRL]], number: 1);

        /** @When comparing both orders */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is false */
        self::assertFalse($areEqual);
    }

    public function testEqualsWhenArraysAreNestedRecursivelyThenComparesElementWise(): void
    {
        /** @Given an Order with nested arrays of Money instances */
        $left = new Order(
            items: [
                [new Money(amount: 1, currency: Currency::BRL), new Money(amount: 2, currency: Currency::BRL)],
                [new Money(amount: 3, currency: Currency::USD)]
            ],
            number: 1
        );

        /** @And another Order with separately constructed nested arrays matching the same state */
        $right = new Order(
            items: [
                [new Money(amount: 1, currency: Currency::BRL), new Money(amount: 2, currency: Currency::BRL)],
                [new Money(amount: 3, currency: Currency::USD)]
            ],
            number: 1
        );

        /** @When comparing both orders */
        $areEqual = $left->equals(other: $right);

        /** @Then the result is true */
        self::assertTrue($areEqual);
    }
}
