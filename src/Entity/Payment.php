<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Enum\PaymentType;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Оплата.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 37
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Payment implements ApiEntityInterface
{
    /**
     * Вид оплаты.
     *
     * @required true
     * @tagFFD   1031 сумма по чеку (БСО) наличными
     * @tagFFD   1081 Сумма по чеку безналичными
     * @tagFFD   1215 Сумма по чеку предоплатой (зачет аванса и (или) предыдущих платежей)
     * @tagFFD   1216 Сумма по чеку постоплатой (кредит)
     * @tagFFD   1217 Сумма по чеку встречным представлением
     */
    private null|PaymentType $type = null;

    /**
     * Сумма к оплате в рублях:
     * • целая часть не более 8 знаков;
     * • дробная часть не более 2 знаков.
     * Максимальное значение – 42 949 672.95.
     *
     * @required true
     */
    private null|int|float $sum = null;

    public function getType(): null|PaymentType
    {
        return $this->type;
    }

    public function setType(null|PaymentType $type): Payment
    {
        $this->type = $type;

        return $this;
    }

    public function getSum(): float|int|null
    {
        return $this->sum;
    }

    public function setSum(float|int|null $sum): Payment
    {
        $this->sum = $sum;

        return $this;
    }
}
