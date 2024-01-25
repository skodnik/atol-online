<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Trait;

use Vlsv\AtolOnline\Exception\ApiExceptionOutOfRangeNumber;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait PriceTrait
{
    /**
     * Цена в рублях:
     * • целая часть не более 8 знаков;
     * • дробная часть не более 2 знаков.
     * Максимальное значение цены – 42 949 672.95.
     * При этом произведение цены и количество/веса (price*quantity) позиции должно быть не больше
     * максимального значения цены позиции.
     *
     * @required true
     * @tagFFD   1079 Цена за единицу предмета расчета с учетом скидок и наценок
     */
    private null|int|float $price = null;

    public function getPrice(): null|int|float
    {
        return $this->price;
    }

    /**
     * @throws ApiExceptionOutOfRangeNumber
     */
    public function setPrice(null|int|float $price): static
    {
        if ($price > 42949672.95 || $price < 0) {
            throw new ApiExceptionOutOfRangeNumber(message: 'Price out of range, max: 42949672.95, min: 0');
        }

        $this->price = $price;

        return $this;
    }
}
