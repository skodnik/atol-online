<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Request;

use DateTimeImmutable;
use Vlsv\AtolOnline\Entity\Correction;
use Vlsv\AtolOnline\Entity\Service;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Пакет POST запроса для чеков коррекции прихода и коррекции расхода.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 36
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class RequestCorrection implements ApiEntityInterface
{
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
     * @required true
     */
    private null|DateTimeImmutable $timestamp = null;

    /**
     * Идентификатор документа внешней системы, уникальный среди всех документов, отправляемых в данную группу
     * ККТ. Тип данных – строка.
     * Предназначен для защиты от потери документов при разрывах связи – всегда можно подать повторно чек с таким
     * же external_id. Если данный external_id известен системе, будет возвращен UUID, ранее присвоенный этому чеку,
     * иначе чек добавится в систему с присвоением нового UUID. Максимальная длина строки – 128 символов.
     *
     * @required false
     */
    private null|string $external_id = null;

    /**
     * Служебный раздел.
     *
     * @required false
     */
    private null|Service $service = null;

    /**
     * Коррекция.
     *
     * @required true
     */
    private null|Correction $correction = null;


    public function getTimestamp(): null|DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function setTimestamp(null|DateTimeImmutable $timestamp): RequestCorrection
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getExternalId(): null|string
    {
        return $this->external_id;
    }

    public function setExternalId(null|string $external_id): RequestCorrection
    {
        $this->external_id = $external_id;

        return $this;
    }

    public function getService(): null|Service
    {
        return $this->service;
    }

    public function setService(null|Service $service): RequestCorrection
    {
        $this->service = $service;

        return $this;
    }

    public function getCorrection(): null|Correction
    {
        return $this->correction;
    }

    public function setCorrection(null|Correction $correction): RequestCorrection
    {
        $this->correction = $correction;

        return $this;
    }
}
