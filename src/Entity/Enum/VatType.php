<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Enum;

/**
 * Устанавливает номер налога в ККТ.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 26
 * @tagFFD  1199 Ставка НДС
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
enum VatType: string
{
    /**
     * Без НДС
     * @tagFFD 1105 Сумма расчета по чеку без НДС
     */
    case NONE = 'none';

    /**
     * НДС чека по ставке 0%.
     * @tagFFD 1104 Сумма расчета по чеку с НДС по ставке 0%
     */
    case VAT0 = 'vat0';

    /**
     * НДС чека по ставке 5%
     * @tagFFD 1107 Сумма НДС чека по ставке 5%
     */
    case VAT5 = 'vat5';

    /**
     * НДС чека по ставке 7%
     * С 17.12.2024
     * @tagFFD 1107 Сумма НДС чека по ставке 7%
     */
    case VAT7 = 'vat7';

    /**
     * НДС чека по ставке 10%.
     * @tagFFD 1103 Сумма НДС чека по ставке 10%
     */
    case VAT10 = 'vat10';

    /**
     * НДС чека по ставке 20%.
     * @tagFFD 1102 Сумма НДС чека по ставке 20%
     */
    case VAT20 = 'vat20';

    /**
     * НДС чека по ставке 22%.
     * 18.11.2025 в метод регистрации документа в параметры налогов vats и vat добавлены новые значения.
     * @tagFFD 1102 Сумма НДС чека по ставке 22%
     */
    case VAT22 = 'vat22';
}
