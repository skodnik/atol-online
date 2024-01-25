<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Enum;

/**
 * Тип операции, которая должна быть выполнена.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 14
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
enum OperationType: string
{
    // Чек "Приход".
    case SELL = 'sell';

    // Чек "Возврат прихода".
    case SELL_REFUND = 'sell_refund';

    // Чек "Коррекция прихода".
    case SELL_CORRECTION = 'sell_correction';

    // Чек "Расход".
    case BUY = 'buy';

    // Чек "Возврат расхода".
    case BUY_REFUND = 'buy_refund';

    // Чек "Коррекция расхода".
    case BUY_CORRECTION = 'buy_correction';
}
