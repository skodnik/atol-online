<?php

declare(strict_types=1);

namespace Unit;

use Vlsv\AtolOnline\Entity\Enum\VatType;
use Vlsv\AtolOnline\Helper\VatHelper;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class VatHelperTest extends TestCase
{
    public function calculateSumByVatDefaultProvider(): array
    {
        return [
            // Кейсы, где НДС включен в сумму (isVatIncluded = true)
            [0, VatType::NONE, 100],
            [0, VatType::VAT0, 100],
            [9.09, VatType::VAT10, 100],
            [27.27, VatType::VAT10, 300],
            [16.67, VatType::VAT20, 100],
            [50.00, VatType::VAT20, 300],
            [18.03, VatType::VAT22, 100],
            [54.10, VatType::VAT22, 300],
        ];
    }

    public function calculateSumByVatProvider(): array
    {
        return [
            // Кейсы, где НДС включен в сумму (isVatIncluded = true)
            [0, VatType::NONE, 100, true],
            [0, VatType::VAT0, 100, true],
            [4.76, VatType::VAT5, 100, true],
            [6.54, VatType::VAT7, 100, true],
            [9.09, VatType::VAT10, 100, true],
            [27.27, VatType::VAT10, 300, true],
            [16.67, VatType::VAT20, 100, true],
            [50.00, VatType::VAT20, 300, true],
            [18.03, VatType::VAT22, 100, true],
            [54.10, VatType::VAT22, 300, true],

            // Кейсы, где НДС начисляется на сумму (isVatIncluded = false)
            [0, VatType::NONE, 100, false],
            [0, VatType::VAT0, 100, false],
            [5.0, VatType::VAT5, 100, false],
            [7.0, VatType::VAT7, 100, false],
            [10.0, VatType::VAT10, 100, false],
            [30.0, VatType::VAT10, 300, false],
            [20.0, VatType::VAT20, 100, false],
            [60.0, VatType::VAT20, 300, false],
            [22.0, VatType::VAT22, 100, false],
            [66.0, VatType::VAT22, 300, false],
        ];
    }

    /**
     * @group        unit
     * @dataProvider calculateSumByVatProvider
     */
    public function testCalculateSumByVat(float $expected, VatType $type, float $sum, bool $isVatIncluded)
    {
        $result = VatHelper::calculateSumByVat($type, $sum, $isVatIncluded);

        self::assertEquals($expected, $result);
    }

    /**
     * @group        unit
     * @dataProvider calculateSumByVatDefaultProvider
     */
    public function testCalculateSumByVatDefault(float $expected, VatType $type, float $sum)
    {
        $result = VatHelper::calculateSumByVat($type, $sum);

        self::assertEquals($expected, $result);
    }
}
