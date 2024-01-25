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
        $sum = match ($type) {
            VatType::NONE => 0,
            VatType::VAT0 => 0,
            VatType::VAT10 => $sum / (1 + (10 / 100)) * (10 / 100),
            VatType::VAT18 => $sum / (1 + (18 / 100)) * (18 / 100), // Deprecated 01.04.2019
            VatType::VAT20 => $sum / (1 + (20 / 100)) * (20 / 100),
            VatType::VAT110 => $sum / (1 + (10 / 110)) * (10 / 110),
            VatType::VAT118 => $sum / (1 + (18 / 118)) * (18 / 118), // Deprecated 01.04.2019
            VatType::VAT120 => $sum / (1 + (20 / 120)) * (20 / 120),
            default => 0,
        };

        return round($sum, 2);
    }
}
