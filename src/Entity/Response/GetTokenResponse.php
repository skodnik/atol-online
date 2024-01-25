<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Response;

use DateTimeImmutable;
use Vlsv\AtolOnline\Entity\Error;

/**
 * Ответ на запрос получения токена.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 13
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class GetTokenResponse
{
    private null|string $token = null;
    private null|Error $error = null;
    /**
     * @Type("DateTimeImmutable<'d.m.Y H:i:s'>")
     */
    private null|DateTimeImmutable $timestamp = null;

    public function getToken(): null|string
    {
        return $this->token;
    }

    public function getError(): null|Error
    {
        return $this->error;
    }

    public function getTimestamp(): null|DateTimeImmutable
    {
        return $this->timestamp;
    }
}
