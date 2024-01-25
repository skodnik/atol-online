<?php

declare(strict_types=1);

namespace Unit;

use Vlsv\AtolOnline\Entity\Item;
use Vlsv\AtolOnline\Entity\Receipt;
use Vlsv\AtolOnline\Tests\Factory\ItemsFactory;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class CalculateTotalTest extends TestCase
{
    public function calculateTotalProvider(): array
    {
        return [
            [
                600,
                (new ItemsFactory())->fromJson('items-01.json'),
            ],
            [
                600,
                (new ItemsFactory())->fromJson('items-02.json'),
            ],
            [
                1200,
                (new ItemsFactory())->fromJson('items-03.json'),
            ],
            [
                1500,
                (new ItemsFactory())->fromJson('items-04.json'),
            ],
            [
                1500,
                (new ItemsFactory())->fromJson('items-05.json'),
            ],
        ];
    }

    /**
     * @group        unit
     * @dataProvider calculateTotalProvider
     *
     * @param int|float $expected
     * @param Item[]    $items
     */
    public function testCalculateTotal(int|float $expected, array $items)
    {
        $total = Receipt::calculateTotal($items);

        self::assertEquals($expected, $total);
    }
}
