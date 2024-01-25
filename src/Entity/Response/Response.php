<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Response;

use DateTimeImmutable;
use Vlsv\AtolOnline\Entity\Enum\Status;
use Vlsv\AtolOnline\Entity\Error;

/**
 * Пакет ответа на POST запрос.
 *
 * @see API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 39
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Response
{
    /**
     * Уникальный идентификатор. Максимальная длина строки – 128 символов.
     * Если документ не удалось зарегистрировать, документу не будет присвоен UUID.
     */
    private null|string $uuid = null;

    /**
     * Дата и время документа внешней системы в формате: «dd.mm.yyyy HH:MM:SS»
     * • dd – День месяца. Формат DD. Возможные значения от «01» до «31».
     * • mm – Месяц. Формат MM. Возможные значения от «01» до «12».
     * • yyyy – Год. Формат YYYY. Допустимое количество символов – четыре.
     * • HH – Часы. Формат HH. Возможные значения от «00» до «24».
     * • MM – Минуты. Формат MM. Возможные значения от «00» до «59».
     * • SS – Секунды. Формат SS. Возможные значения от «00» до «59».
     *
     * @Type("DateTimeImmutable<'d.m.Y H:i:s'>")
     */
    private null|DateTimeImmutable $timestamp = null;

    /**
     * Статус.
     */
    private null|Status $status = null;

    /**
     * Описание ошибки.
     */
    private null|Error $error;

    public function getUuid(): null|string
    {
        return $this->uuid;
    }

    public function setUuid(null|string $uuid): Response
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getTimestamp(): null|DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function setTimestamp(null|DateTimeImmutable $timestamp): Response
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getStatus(): null|string
    {
        return $this->status?->value;
    }

    public function setStatus(null|Status $status): Response
    {
        $this->status = $status;

        return $this;
    }

    public function getError(): null|Error
    {
        return $this->error;
    }

    public function setError(null|Error $error): Response
    {
        $this->error = $error;

        return $this;
    }
}
