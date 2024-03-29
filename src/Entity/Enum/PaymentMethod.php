<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Enum;

/**
 * Признак способа расчёта.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 23
 * @tagFFD  1214 Признак способа расчета
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
enum PaymentMethod: string
{
    /**
     * Предоплата 100%. Полная предварительная оплата до момента передачи предмета расчета.
     */
    case FULL_PREPAYMENT = 'full_prepayment';

    /**
     * Предоплата. Частичная предварительная оплата до момента передачи предмета расчета.
     */
    case PREPAYMENT = 'prepayment';

    /**
     * Аванс.
     */
    case ADVANCE = 'advance';

    /**
     * Полный расчет. Полная оплата, в том числе с учетом аванса (предварительной оплаты) в момент передачи предмета
     * расчета.
     */
    case FULL_PAYMENT = 'full_payment';

    /**
     * Частичный расчет и кредит. Частичная оплата предмета расчета в момент его передачи с последующей оплатой в
     * кредит.
     */
    case PARTIAL_PAYMENT = 'partial_payment';

    /**
     * Передача в кредит. Передача предмета расчета без его оплаты в момент его передачи с последующей оплатой в кредит.
     */
    case CREDIT = 'credit';

    /**
     * Оплата кредита. Оплата предмета расчета после его передачи с оплатой в кредит (оплата кредита).
     */
    case CREDIT_PAYMENT = 'credit_payment';
}
