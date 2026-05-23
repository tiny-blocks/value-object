<?php

declare(strict_types=1);

namespace TinyBlocks\Vo\Unit;

use PHPUnit\Framework\TestCase;
use TinyBlocks\Vo\Models\Coordinate;
use TinyBlocks\Vo\Models\Currency;
use TinyBlocks\Vo\Models\Invoice;
use TinyBlocks\Vo\Models\MixedVisibilityProfile;
use TinyBlocks\Vo\Models\Money;
use TinyBlocks\Vo\Models\Order;
use TinyBlocks\Vo\Models\Point;
use TinyBlocks\Vo\Models\PrivateMoney;
use TinyBlocks\Vo\Models\Profile;
use TinyBlocks\Vo\Models\Rating;

final class ValueObjectBehaviorHashCodeTest extends TestCase
{
    public function testHashCodeWhenArrayOrderDiffersThenHashesDiffer(): void
    {
        /** @Given an Order with items in ascending order */
        $left = new Order(items: [1, 2, 3], number: 1);

        /** @And another Order with the same items in descending order */
        $right = new Order(items: [3, 2, 1], number: 1);

        /** @When checking whether both hashes differ */
        $haveDifferentHashes = $left->hashCode() !== $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveDifferentHashes);
    }

    public function testHashCodeWhenBackedEnumCaseDiffersThenHashesDiffer(): void
    {
        /** @Given a Money instance priced in BRL */
        $left = new Money(amount: 50, currency: Currency::BRL);

        /** @And another Money instance with the same amount priced in USD */
        $right = new Money(amount: 50, currency: Currency::USD);

        /** @When checking whether both hashes differ */
        $haveDifferentHashes = $left->hashCode() !== $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveDifferentHashes);
    }

    public function testHashCodeWhenScalarPropertyDiffersThenHashesDiffer(): void
    {
        /** @Given a Money instance for one hundred BRL */
        $left = new Money(amount: 100, currency: Currency::BRL);

        /** @And another Money instance with a different amount */
        $right = new Money(amount: 200, currency: Currency::BRL);

        /** @When checking whether both hashes differ */
        $haveDifferentHashes = $left->hashCode() !== $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveDifferentHashes);
    }

    public function testHashCodeWhenPrivatePropertyDiffersThenHashesDiffer(): void
    {
        /** @Given a PrivateMoney instance for one hundred BRL */
        $left = new PrivateMoney(amount: 100, currency: Currency::BRL);

        /** @And another PrivateMoney instance with a different amount */
        $right = new PrivateMoney(amount: 200, currency: Currency::BRL);

        /** @When checking whether both hashes differ */
        $haveDifferentHashes = $left->hashCode() !== $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveDifferentHashes);
    }

    public function testHashCodeWhenInstancesAreEqualByEqualsThenHashesMatch(): void
    {
        /** @Given a Money instance priced in BRL */
        $left = new Money(amount: 100, currency: Currency::BRL);

        /** @And another Money instance equal by equals */
        $right = new Money(amount: 100, currency: Currency::BRL);

        /** @When checking whether both hashes match */
        $haveSameHash = $left->hashCode() === $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveSameHash);
    }

    public function testHashCodeWhenScalarArrayElementDiffersThenHashesDiffer(): void
    {
        /** @Given an Order with a single scalar item */
        $left = new Order(items: [10], number: 1);

        /** @And another Order with a different scalar item */
        $right = new Order(items: [20], number: 1);

        /** @When checking whether both hashes differ */
        $haveDifferentHashes = $left->hashCode() !== $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveDifferentHashes);
    }

    public function testHashCodeWhenNestedValueObjectStateDiffersThenHashesDiffer(): void
    {
        /** @Given an Invoice for five hundred USD */
        $left = new Invoice(total: new Money(amount: 500, currency: Currency::USD), number: 1);

        /** @And another Invoice carrying a different Money total */
        $right = new Invoice(total: new Money(amount: 750, currency: Currency::USD), number: 1);

        /** @When checking whether both hashes differ */
        $haveDifferentHashes = $left->hashCode() !== $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveDifferentHashes);
    }

    public function testHashCodeWhenDifferentClassesShareSameShapeThenHashesDiffer(): void
    {
        /** @Given a Coordinate instance */
        $coordinate = new Coordinate(latitude: 10.0, longitude: 20.0);

        /** @And a Point instance with identical scalar state */
        $point = new Point(latitude: 10.0, longitude: 20.0);

        /** @When checking whether both hashes differ */
        $haveDifferentHashes = $coordinate->hashCode() !== $point->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveDifferentHashes);
    }

    public function testHashCodeWhenPrivatePropertiesShareSameStateThenHashesMatch(): void
    {
        /** @Given a PrivateMoney instance priced in BRL */
        $left = new PrivateMoney(amount: 100, currency: Currency::BRL);

        /** @And another PrivateMoney instance with identical state */
        $right = new PrivateMoney(amount: 100, currency: Currency::BRL);

        /** @When computing the hash of both instances */
        $haveSameHash = $left->hashCode() === $right->hashCode();

        /** @Then both hashes match */
        self::assertTrue($haveSameHash);
    }

    public function testHashCodeWhenStaticPropertyExistsThenOnlyInstanceStateIsHashed(): void
    {
        /** @Given a Rating instance whose class also declares a static property */
        $rating = new Rating(score: 5);

        /** @When computing the structural hash */
        $hashCode = $rating->hashCode();

        /** @Then the hash reflects only the instance state, excluding the static property */
        self::assertSame(hash('xxh128', "TinyBlocks\\Vo\\Models\\Rating|score=5"), $hashCode);
    }

    public function testHashCodeWhenInvokedTwiceOnSameInstanceThenHashesAreDeterministic(): void
    {
        /** @Given a Money instance */
        $money = new Money(amount: 250, currency: Currency::EUR);

        /** @When invoked twice */
        $first = $money->hashCode();
        $second = $money->hashCode();

        /** @Then both invocations return the same hash */
        self::assertSame($first, $second);
    }

    public function testHashCodeWhenNullablePropertyDiffersFromPopulatedThenHashesDiffer(): void
    {
        /** @Given a Profile without a nickname */
        $left = new Profile(name: 'Ada', nickname: null);

        /** @And another Profile carrying a nickname */
        $right = new Profile(name: 'Ada', nickname: 'Lovelace');

        /** @When checking whether both hashes differ */
        $haveDifferentHashes = $left->hashCode() !== $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveDifferentHashes);
    }

    public function testHashCodeWhenNullablePropertyIsNullInBothInstancesThenHashesMatch(): void
    {
        /** @Given a Profile without a nickname */
        $left = new Profile(name: 'Ada', nickname: null);

        /** @And another Profile without a nickname */
        $right = new Profile(name: 'Ada', nickname: null);

        /** @When checking whether both hashes match */
        $haveSameHash = $left->hashCode() === $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveSameHash);
    }

    public function testHashCodeWhenNullablePropertyIsNullThenSerializesNullAsLiteralNull(): void
    {
        /** @Given a Profile whose nickname is null */
        $profile = new Profile(name: 'Ada', nickname: null);

        /** @When computing the structural hash */
        $hashCode = $profile->hashCode();

        /** @Then the hash matches the xxh128 of the documented serialization with NULL for the null property */
        self::assertSame(hash('xxh128', "TinyBlocks\\Vo\\Models\\Profile|name='Ada'|nickname=NULL"), $hashCode);
    }

    public function testHashCodeWhenArrayOfNestedValueObjectsCarriesSameStateThenHashesMatch(): void
    {
        /** @Given an Order containing distinct Money instances */
        $left = new Order(
            items: [
                new Money(amount: 10, currency: Currency::BRL),
                new Money(amount: 20, currency: Currency::USD)
            ],
            number: 1
        );

        /** @And another Order with separately constructed Money instances matching the same state */
        $right = new Order(
            items: [
                new Money(amount: 10, currency: Currency::BRL),
                new Money(amount: 20, currency: Currency::USD)
            ],
            number: 1
        );

        /** @When checking whether both hashes match */
        $haveSameHash = $left->hashCode() === $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveSameHash);
    }

    public function testHashCodeWhenMixedVisibilityPropertiesDifferOnPrivateThenHashesDiffer(): void
    {
        /** @Given a MixedVisibilityProfile with a specific nickname */
        $left = new MixedVisibilityProfile(name: 'Ada', nickname: 'Lovelace');

        /** @And another MixedVisibilityProfile with the same name but a different nickname */
        $right = new MixedVisibilityProfile(name: 'Ada', nickname: 'Byron');

        /** @When checking whether both hashes differ */
        $haveDifferentHashes = $left->hashCode() !== $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveDifferentHashes);
    }

    public function testHashCodeWhenNestedValueObjectsAreDistinctInstancesWithSameStateThenHashesMatch(): void
    {
        /** @Given an Invoice with a Money total */
        $left = new Invoice(total: new Money(amount: 99, currency: Currency::USD), number: 1);

        /** @And another Invoice with a separately constructed Money carrying the same state */
        $right = new Invoice(total: new Money(amount: 99, currency: Currency::USD), number: 1);

        /** @When checking whether both hashes match */
        $haveSameHash = $left->hashCode() === $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveSameHash);
    }

    public function testHashCodeWhenBackedEnumPropertiesShareSameCaseInDistinctInstancesThenHashesMatch(): void
    {
        /** @Given a Money instance priced in USD */
        $left = new Money(amount: 75, currency: Currency::USD);

        /** @And another distinct Money instance priced in USD */
        $right = new Money(amount: 75, currency: Currency::USD);

        /** @When checking whether both hashes match */
        $haveSameHash = $left->hashCode() === $right->hashCode();

        /** @Then the result is true */
        self::assertTrue($haveSameHash);
    }
}
