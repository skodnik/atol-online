<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Trait;

use Vlsv\AtolOnline\Exception\ApiExceptionOutOfRangeNumber;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait QuantityTrait
{
    /**
     * Количество/вес:
     * • целая часть не более 5 знаков;
     * • дробная часть не более 3 знаков.
     * Максимальное значение – 99 999.999
     *
     * @required true
     * @tagFFD   1023 Количество предмета расчета
     */
    private null|int|float $quantity = null;

    public function getQuantity(): null|int|float
    {
        return $this->quantity;
    }

    /**
     * @throws ApiExceptionOutOfRangeNumber
     */
    public function setQuantity(null|int|float $quantity): static
    {
        if ($quantity > 99999.999 || $quantity < 0) {
            throw new ApiExceptionOutOfRangeNumber(message: 'Quantity out of range, max: 99999.999, min: 0');
        }

        $this->quantity = $quantity;

        return $this;
    }
}
