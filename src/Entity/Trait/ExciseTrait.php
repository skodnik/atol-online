<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Trait;

use Vlsv\AtolOnline\Exception\ApiExceptionOutOfRangeNumber;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait ExciseTrait
{
    /**
     * Сумма акциза в рублях
     * • целая часть не более 8 знаков;
     * • дробная часть не более 2 знаков;
     * • значение не может быть отрицательным;
     *
     * @required false
     * @tagFFD   1229 Сумма акциза с учетом копеек, включенная в стоимость предмета расчета
     */
    private null|int|float $excise = null;

    public function getExcise(): null|string
    {
        return $this->excise;
    }

    /**
     * @throws ApiExceptionOutOfRangeNumber
     */
    public function setExcise(null|int|float $excise): static
    {
        if ($excise < 0) {
            throw new ApiExceptionOutOfRangeNumber(message: 'Excise out of range, min: 0');
        }

        $this->excise = $excise;

        return $this;
    }
}
