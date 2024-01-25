<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Trait;

use Vlsv\AtolOnline\Exception\ApiExceptionOutOfRangeNumber;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait SumTrait
{
    /**
     * Сумма в рублях:
     * • целая часть не более 8 знаков;
     * • дробная часть не более 2 знаков.
     * Максимальное значение цены – 42 949 672.95.
     *
     * @required true
     * @tagFFD   1043 Стоимость предмета расчета с учетом скидок и наценок
     */
    private null|int|float $sum = null;

    public function getSum(): null|int|float
    {
        return $this->sum;
    }

    /**
     * @throws ApiExceptionOutOfRangeNumber
     */
    public function setSum(null|int|float $sum): static
    {
        if ($sum > 42949672.95 || $sum < 0) {
            throw new ApiExceptionOutOfRangeNumber(message: 'Sum out of range, max: 42949672.95, min: 0');
        }

        $this->sum = $sum;

        return $this;
    }
}
