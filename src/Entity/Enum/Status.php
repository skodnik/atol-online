<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Enum;

/**
 * Статус.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 39
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
enum Status: string
{
    /**
     * Ошибка.
     */
    case WAIT = 'wait';

    /**
     * Успех.
     */
    case DONE = 'done';

    /**
     * Ожидание.
     */
    case FAIL = 'fail';

    /**
     * Также в моменты обновления платформы возможны временные перебои в работе касс,
     * из-за которого возможны появление чеков в статусе «Таймаут»
     */
    case TIMEOUT = 'timeout';
}
