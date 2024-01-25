<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Enum\VatType;

/**
 * Атрибуты налогов на чек коррекции.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 17
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Vat
{
    /**
     * Устанавливает номер налога в ККТ.
     *
     * @required true
     */
    private null|VatType $type = null;

    /**
     * Сумма к оплате в рублях:
     * • целая часть не более 8 знаков;
     * • дробная часть не более 2 знаков.
     * Максимальное значение – 42 949 672.95.
     *
     * @required true
     */
    private null|int|float $sum = null;

    public function getType(): null|VatType
    {
        return $this->type;
    }

    public function setType(null|VatType $type): Vat
    {
        $this->type = $type;

        return $this;
    }

    public function getSum(): float|int|null
    {
        return $this->sum;
    }

    public function setSum(float|int|null $sum): Vat
    {
        $this->sum = $sum;

        return $this;
    }
}
