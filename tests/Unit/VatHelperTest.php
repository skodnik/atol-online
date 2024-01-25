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
    public function calculateSumByVatProvider(): array
    {
        return [
            [0, VatType::NONE, 100],
            [0, VatType::VAT0, 100],
            [9.09, VatType::VAT10, 100],
            [27.27, VatType::VAT10, 300],
            [16.67, VatType::VAT20, 100],
            [50.00, VatType::VAT20, 300],
            [8.33, VatType::VAT110, 100],
            [25.0, VatType::VAT110, 300],
            [14.29, VatType::VAT120, 100],
            [42.86, VatType::VAT120, 300],
        ];
    }

    /**
     * @group        unit
     * @dataProvider calculateSumByVatProvider
     */
    public function testCalculateSumByVat(float $expected, VatType $type, float $sum)
    {
        $result = VatHelper::calculateSumByVat($type, $sum);

        self::assertEquals($expected, $result);
    }
}
