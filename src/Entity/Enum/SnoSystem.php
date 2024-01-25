<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Enum;

/**
 * Система налогообложения.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 19
 * @tagFFD  1055 Применяемая система налогообложения
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
enum SnoSystem: string
{
    /**
     * Общая СН.
     */
    case OSN = 'osn';

    /**
     * Упрощенная СН (доходы).
     */
    case USN_INCOME = 'usn_income';

    /**
     * Упрощенная СН (доходы минус расходы).
     */
    case USN_INCOME_OUTCOME = 'usn_income_outcome';

    /**
     * Единый налог на вмененный доход.
     */
    case ENVD = 'envd';

    /**
     * Единый сельскохозяйственный налог.
     */
    case ESN = 'esn';

    /**
     * Патентная СН.
     */
    case PATENT = 'patent';
}
