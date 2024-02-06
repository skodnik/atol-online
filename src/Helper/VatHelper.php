<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Helper;

use Vlsv\AtolOnline\Entity\Enum\VatType;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class VatHelper
{
    public static function calculateSumByVat(VatType $type, int|float $sum): float|int
    {
        $vatPercentage = match ($type) {
            VatType::NONE, VatType::VAT0 => [0, 100],
            VatType::VAT10 => [10, 100],
            VatType::VAT18 => [18, 100], // Deprecated 01.04.2019
            VatType::VAT20 => [20, 100],
            VatType::VAT110 => [10, 110],
            VatType::VAT118 => [18, 118], // Deprecated 01.04.2019
            VatType::VAT120 => [20, 120],
            default => [0, 100],
        };

        $vat = $sum / ($vatPercentage[0] + $vatPercentage[1]) * $vatPercentage[0];

        return round($vat, 2);
    }
}
