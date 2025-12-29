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
    public static function calculateSumByVat(VatType $type, int|float $sum, bool $isVatIncluded = true): float|int
    {
        $vatPercentage = match ($type) {
            VatType::NONE, VatType::VAT0 => [0, 100],
            VatType::VAT5 => [5, 100],
            VatType::VAT7 => [7, 100],
            VatType::VAT10 => [10, 100],
            VatType::VAT20 => [20, 100],
            VatType::VAT22 => [22, 100],
            default => [0, 100],
        };

        $vat = $isVatIncluded
            ? $sum / ($vatPercentage[0] + $vatPercentage[1]) * $vatPercentage[0]
            : $sum / $vatPercentage[1] * $vatPercentage[0];

        return round($vat, 2);
    }
}
