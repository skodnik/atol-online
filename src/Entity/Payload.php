<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Реквизиты фискализации документа.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 44
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Payload implements ApiEntityInterface
{
    /**
     * Номер чека в смене.
     *
     * @tagFFD 1042 Номер чека за смену
     */
    private null|int $fiscal_receipt_number = null;

    /**
     * Дата и время документа из ФН.
     *
     * @tagFFD 1012 Дата, время
     */
    private null|string $receipt_datetime = null;

    /**
     * Итоговая сумма документа в рублях с заданным в CMS округлением:
     * • целая часть не более 8 знаков;
     * • дробная часть не более 2 знаков.
     * При регистрации в ККТ происходит расчёт фактической суммы:
     * суммирование значений sum позиций.
     *
     * @tagFFD 1020 Сумма расчета, указанного в чеке (БСО)
     */
    private null|int|float $total = null;

    /**
     * Номер ФН.
     *
     * @tagFFD 1041 Номер ФН
     */
    private null|string $fn_number = null;

    /**
     * Регистрационный номер ККТ.
     *
     * @tagFFD 1037 Регистрационный номер ККТ
     */
    private null|string $ecr_registration_number = null;

    /**
     * Фискальный номер документа.
     *
     * @tagFFD 1040 Номер ФД
     */
    private null|int $fiscal_document_number = null;

    /**
     * Фискальный признак документа.
     *
     * @tagFFD 1077 ФПД
     */
    private null|int $fiscal_document_attribute = null;

    /**
     * Адрес сайта ФНС.
     *
     * @tagFFD 1060 Адрес сайта ФНС
     */
    private null|string $fns_site = null;

    /**
     * Идентификационный номер налогоплательщика оператора фискальных данных.
     *
     * @tagFFD 1017 ИНН ОФД
     */
    private null|string $ofd_inn = null;

    /**
     * URL для просмотра чека на сайте ОФД. Отображается только для чеков, зарегистрированных с помощью:
     * • Платформа ОФД (ООО "Эвотор ОФД", ИНН 9715260691)
     * • Первый ОФД (АО "ЭСК", ИНН 7709364346)
     * • Такском ОФД
     */
    private null|string $ofd_receipt_url = null;

    public function getFiscalReceiptNumber(): null|int
    {
        return $this->fiscal_receipt_number;
    }

    public function setFiscalReceiptNumber(null|int $fiscal_receipt_number): Payload
    {
        $this->fiscal_receipt_number = $fiscal_receipt_number;

        return $this;
    }

    public function getReceiptDatetime(): null|string
    {
        return $this->receipt_datetime;
    }

    public function setReceiptDatetime(null|string $receipt_datetime): Payload
    {
        $this->receipt_datetime = $receipt_datetime;

        return $this;
    }

    public function getTotal(): null|int|float
    {
        return $this->total;
    }

    public function setTotal(null|int|float $total): Payload
    {
        $this->total = $total;

        return $this;
    }

    public function getFnNumber(): null|string
    {
        return $this->fn_number;
    }

    public function setFnNumber(null|string $fn_number): Payload
    {
        $this->fn_number = $fn_number;

        return $this;
    }

    public function getEcrRegistrationNumber(): null|string
    {
        return $this->ecr_registration_number;
    }

    public function setEcrRegistrationNumber(null|string $ecr_registration_number): Payload
    {
        $this->ecr_registration_number = $ecr_registration_number;

        return $this;
    }

    public function getFiscalDocumentNumber(): null|int
    {
        return $this->fiscal_document_number;
    }

    public function setFiscalDocumentNumber(null|int $fiscal_document_number): Payload
    {
        $this->fiscal_document_number = $fiscal_document_number;

        return $this;
    }

    public function getFiscalDocumentAttribute(): null|int
    {
        return $this->fiscal_document_attribute;
    }

    public function setFiscalDocumentAttribute(null|int $fiscal_document_attribute): Payload
    {
        $this->fiscal_document_attribute = $fiscal_document_attribute;

        return $this;
    }

    public function getFnsSite(): null|string
    {
        return $this->fns_site;
    }

    public function setFnsSite(null|string $fns_site): Payload
    {
        $this->fns_site = $fns_site;

        return $this;
    }

    public function getOfdInn(): null|string
    {
        return $this->ofd_inn;
    }

    public function setOfdInn(null|string $ofd_inn): Payload
    {
        $this->ofd_inn = $ofd_inn;

        return $this;
    }

    public function getOfdReceiptUrl(): null|string
    {
        return $this->ofd_receipt_url;
    }

    public function setOfdReceiptUrl(null|string $ofd_receipt_url): Payload
    {
        $this->ofd_receipt_url = $ofd_receipt_url;

        return $this;
    }
}
