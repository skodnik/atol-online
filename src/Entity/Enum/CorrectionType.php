<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Enum;

/**
 * Тип коррекции.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 37
 * @tagFFD  1173 Тип коррекции
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
enum CorrectionType: string
{
    /**
     * Самостоятельно.
     */
    case INDEPENDENTLY = 'self';

    /**
     * По предписанию.
     */
    case INSTRUCTION = 'instruction';
}
