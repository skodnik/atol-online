<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Response;

use DateTimeImmutable;
use Vlsv\AtolOnline\Entity\Enum\Status;
use Vlsv\AtolOnline\Entity\Error;
use Vlsv\AtolOnline\Entity\Warnings;

/**
 * Ответ при успешной фискализации.
 *
 * @see API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 42
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Report
{
    /**
     * Уникальный идентификатор.
     * Максимальная длина строки – 128 символов. Если документ не удалось зарегистрировать, документу не будет
     * присвоен UUID.
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
     * URL, на который необходимо ответить после обработки документа.
     */
    private null|string $callback_url = null;

    /**
     * Статус. Возможные значения:
     * • «done» – готово;
     * • «fail» – ошибка;
     * • «wait» – ожидание.
     */
    private null|Status $status = null;

    /**
     * Идентификатор группы ККТ.
     */
    private null|string $group_code = null;

    /**
     * Наименование сервера.
     */
    private null|string $daemon_code = null;

    /**
     * Код ККТ.
     */
    private null|string $device_code = null;

    /**
     * Идентификатор документа внешней системы, уникальный среди всех документов, отправленных в данную группу ККТ.
     */
    private null|string $external_id = null;

    /**
     * Реквизиты фискализации документа.
     */
    private null|string $payload = null;

    /**
     * Описание ошибки.
     */
    private null|Error $error = null;


    /**
     * Важная информация.
     */
    private null|Warnings $warnings = null;

    public function getUuid(): null|string
    {
        return $this->uuid;
    }

    public function setUuid(null|string $uuid): Report
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getTimestamp(): null|DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function setTimestamp(null|DateTimeImmutable $timestamp): Report
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getCallbackUrl(): null|string
    {
        return $this->callback_url;
    }

    public function setCallbackUrl(null|string $callback_url): Report
    {
        $this->callback_url = $callback_url;

        return $this;
    }

    public function getStatus(): null|Status
    {
        return $this->status;
    }

    public function setStatus(null|Status $status): Report
    {
        $this->status = $status;

        return $this;
    }

    public function getGroupCode(): null|string
    {
        return $this->group_code;
    }

    public function setGroupCode(null|string $group_code): Report
    {
        $this->group_code = $group_code;

        return $this;
    }

    public function getDaemonCode(): null|string
    {
        return $this->daemon_code;
    }

    public function setDaemonCode(null|string $daemon_code): Report
    {
        $this->daemon_code = $daemon_code;

        return $this;
    }

    public function getDeviceCode(): null|string
    {
        return $this->device_code;
    }

    public function setDeviceCode(null|string $device_code): Report
    {
        $this->device_code = $device_code;

        return $this;
    }

    public function getExternalId(): null|string
    {
        return $this->external_id;
    }

    public function setExternalId(null|string $external_id): Report
    {
        $this->external_id = $external_id;

        return $this;
    }

    public function getPayload(): null|string
    {
        return $this->payload;
    }

    public function setPayload(null|string $payload): Report
    {
        $this->payload = $payload;

        return $this;
    }

    public function getError(): null|Error
    {
        return $this->error;
    }

    public function setError(null|Error $error): Report
    {
        $this->error = $error;

        return $this;
    }

    public function getWarnings(): null|Warnings
    {
        return $this->warnings;
    }

    public function setWarnings(null|Warnings $warnings): Report
    {
        $this->warnings = $warnings;

        return $this;
    }
}
