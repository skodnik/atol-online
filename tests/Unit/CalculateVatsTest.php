<?php

declare(strict_types=1);

namespace Unit;

use Vlsv\AtolOnline\Entity\Enum\VatType;
use Vlsv\AtolOnline\Entity\Item;
use Vlsv\AtolOnline\Entity\Receipt;
use Vlsv\AtolOnline\Entity\Vat;
use Vlsv\AtolOnline\Tests\Factory\ItemsFactory;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class CalculateVatsTest extends TestCase
{
    public function calculateVatsProvider(): array
    {
        return [
            [
                [VatType::VAT10->value => 54.54],
                (new ItemsFactory())->fromJson('items-01.json'),
            ],
            [
                [VatType::VAT10->value => 27.27, VatType::VAT0->value => 0],
                (new ItemsFactory())->fromJson('items-02.json'),
            ],
            [
                [VatType::VAT10->value => 27.27, VatType::VAT0->value => 0],
                (new ItemsFactory())->fromJson('items-03.json'),
            ],
            [
                [VatType::VAT10->value => 136.35],
                (new ItemsFactory())->fromJson('items-04.json'),
            ],
            [
                [VatType::VAT10->value => 109.08, VatType::VAT20->value => 50.0],
                (new ItemsFactory())->fromJson('items-05.json'),
            ],
        ];
    }

    /**
     * @group        unit
     * @dataProvider calculateVatsProvider
     *
     * @param Vat[]  $expected
     * @param Item[] $items
     */
    public function testCalculateVats(array $expected, array $items)
    {
        $vats = Receipt::calculateVats($items);

        foreach ($vats as $vat) {
            self::assertEquals($expected[$vat->getType()->value], $vat->getSum());
        }
    }
}
