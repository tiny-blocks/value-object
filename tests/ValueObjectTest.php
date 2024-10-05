<?php

declare(strict_types=1);

namespace TinyBlocks\Vo;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TinyBlocks\Vo\Models\Amount;
use TinyBlocks\Vo\Models\Order;
use TinyBlocks\Vo\Models\Product;

final class ValueObjectTest extends TestCase
{
    #[DataProvider('dataProviderForEqualObjects')]
    public function testValueObjectsAreEqual(ValueObject $valueObject, ValueObject $otherValueObject): void
    {
        /** @Given two ValueObjects that should be equal */
        /** @When comparing both ValueObjects for equality */
        $actual = $valueObject->equals(other: $otherValueObject);

        /** @Then they should be considered equal */
        self::assertTrue($actual);
    }

    #[DataProvider('dataProviderForNotEqualObjects')]
    public function testValueObjectsAreNotEqual(ValueObject $valueObject, ValueObject $otherValueObject): void
    {
        /** @Given two ValueObjects that should not be equal */
        /** @When comparing both ValueObjects for equality */
        $actual = $valueObject->equals(other: $otherValueObject);

        /** @Then they should not be considered equal */
        self::assertFalse($actual);
    }

    public static function dataProviderForEqualObjects(): array
    {
        $productOne = new Product(name: 'Laptop', amount: new Amount(value: 100.0, currency: 'USD'));
        $productTwo = new Product(name: 'Mouse', amount: new Amount(value: 50.0, currency: 'USD'));
        $productDuplicate = new Product(name: 'Laptop', amount: new Amount(value: 100.0, currency: 'USD'));
        $emptyOrderOne = new Order(id: 1, products: []);
        $emptyOrderTwo = new Order(id: 1, products: []);

        return [
            'Empty arrays should be equal'      => [
                'valueObject'      => $emptyOrderOne,
                'otherValueObject' => $emptyOrderTwo
            ],
            'Identical orders same products'    => [
                'valueObject'      => new Order(id: 1, products: [$productOne, $productTwo]),
                'otherValueObject' => new Order(id: 1, products: [$productOne, $productTwo])
            ],
            'Same products different instances' => [
                'valueObject'      => new Order(id: 1, products: [$productOne]),
                'otherValueObject' => new Order(id: 1, products: [$productDuplicate])
            ]
        ];
    }

    public static function dataProviderForNotEqualObjects(): array
    {
        $productOne = new Product(name: 'Laptop', amount: new Amount(value: 100.0, currency: 'USD'));
        $productTwo = new Product(name: 'Mouse', amount: new Amount(value: 50.0, currency: 'USD'));
        $productThree = new Product(name: 'Keyboard', amount: new Amount(value: 75.0, currency: 'USD'));
        $productDifferentAmount = new Product(name: 'Laptop', amount: new Amount(value: 200.0, currency: 'USD'));
        $orderWithNullProduct = new Order(id: 1, products: [null]);
        $orderWithProduct = new Order(id: 1, products: [$productOne]);

        return [
            'Same products, different IDs'             => [
                'valueObject'      => new Order(id: 1, products: [$productOne, $productTwo]),
                'otherValueObject' => new Order(id: 2, products: [$productOne, $productTwo])
            ],
            'Orders with different products'           => [
                'valueObject'      => new Order(id: 1, products: [$productOne, $productTwo]),
                'otherValueObject' => new Order(id: 1, products: [$productOne, $productThree])
            ],
            'Null product vs actual product'           => [
                'valueObject'      => $orderWithNullProduct,
                'otherValueObject' => $orderWithProduct
            ],
            'Same product names but different amounts' => [
                'valueObject'      => new Order(id: 1, products: [$productOne]),
                'otherValueObject' => new Order(id: 1, products: [$productDifferentAmount])
            ]
        ];
    }
}
