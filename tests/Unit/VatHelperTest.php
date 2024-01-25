<?php

declare(strict_types=1);

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
            [10.00, VatType::VAT10, 100],
            [20.00, VatType::VAT20, 100],
            [9.09, VatType::VAT110, 100],
            [16.67, VatType::VAT120, 100],
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
