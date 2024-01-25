<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Enum;

/**
 * Оплаты.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 31
 * @tagFFD  1031сумма по чеку (БСО) наличными
 * @tagFFD  1081 Сумма по чеку безналичными
 * @tagFFD  1215 Сумма по чеку предоплатой (зачет аванса и (или) предыдущих платежей)
 * @tagFFD  1216 Сумма по чеку постоплатой (кредит)
 * @tagFFD  1217 Сумма по чеку встречным представлением
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
enum PaymentType: int
{
    /**
     * Наличные.
     */
    case CASH = 0;

    /**
     * Безналичный.
     */
    case CASHLESS = 1;

    /**
     * Предварительная оплата (зачет аванса и (или) предыдущих платежей).
     */
    case ADVANCE_PAYMENT = 2;

    /**
     * Постоплата (кредит).
     */
    case CREDIT = 3;

    /**
     * Иная форма оплаты (встречное предоставление).
     */
    case OTHER_PAYMENT = 4;

    /**
     * Расширенные виды оплаты (5-9). Для каждого фискального типа оплаты можно указать расширенный вид оплаты.
     */
    case EXTENDED_PAYMENT_5 = 5;

    case EXTENDED_PAYMENT_6 = 6;

    case EXTENDED_PAYMENT_7 = 7;

    case EXTENDED_PAYMENT_8 = 8;

    case EXTENDED_PAYMENT_9 = 9;
}
