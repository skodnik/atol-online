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
    private null|int $total = null;

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

    public function getFiscalReceiptNumber(): ?int
    {
        return $this->fiscal_receipt_number;
    }

    public function setFiscalReceiptNumber(?int $fiscal_receipt_number): Report
    {
        $this->fiscal_receipt_number = $fiscal_receipt_number;

        return $this;
    }

    public function getReceiptDatetime(): ?string
    {
        return $this->receipt_datetime;
    }

    public function setReceiptDatetime(?string $receipt_datetime): Report
    {
        $this->receipt_datetime = $receipt_datetime;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(?int $total): Report
    {
        $this->total = $total;

        return $this;
    }

    public function getFnNumber(): ?string
    {
        return $this->fn_number;
    }

    public function setFnNumber(?string $fn_number): Report
    {
        $this->fn_number = $fn_number;

        return $this;
    }

    public function getEcrRegistrationNumber(): ?string
    {
        return $this->ecr_registration_number;
    }

    public function setEcrRegistrationNumber(?string $ecr_registration_number): Report
    {
        $this->ecr_registration_number = $ecr_registration_number;

        return $this;
    }

    public function getFiscalDocumentNumber(): ?int
    {
        return $this->fiscal_document_number;
    }

    public function setFiscalDocumentNumber(?int $fiscal_document_number): Report
    {
        $this->fiscal_document_number = $fiscal_document_number;

        return $this;
    }

    public function getFiscalDocumentAttribute(): ?int
    {
        return $this->fiscal_document_attribute;
    }

    public function setFiscalDocumentAttribute(?int $fiscal_document_attribute): Report
    {
        $this->fiscal_document_attribute = $fiscal_document_attribute;

        return $this;
    }

    public function getFnsSite(): ?string
    {
        return $this->fns_site;
    }

    public function setFnsSite(?string $fns_site): Report
    {
        $this->fns_site = $fns_site;

        return $this;
    }

    public function getOfdInn(): ?string
    {
        return $this->ofd_inn;
    }

    public function setOfdInn(?string $ofd_inn): Report
    {
        $this->ofd_inn = $ofd_inn;

        return $this;
    }

    public function getOfdReceiptUrl(): ?string
    {
        return $this->ofd_receipt_url;
    }

    public function setOfdReceiptUrl(?string $ofd_receipt_url): Report
    {
        $this->ofd_receipt_url = $ofd_receipt_url;

        return $this;
    }
}
