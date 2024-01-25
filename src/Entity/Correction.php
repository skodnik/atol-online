<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Коррекция.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 37
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Correction implements ApiEntityInterface
{
    /**
     * Атрибуты компании.
     *
     * @required true
     */
    private null|Company $company = null;

    /**
     * Коррекция.
     *
     * @required true
     */
    private null|CorrectionInfo $correction_info = null;
    /**
     * Оплаты. Ограничение по количеству от 1 до 10.
     *
     * @required true
     * @var null|Payment[]
     */
    private null|array $payments = null;
    /**
     * Атрибуты налогов на чек коррекции. Ограничение по количеству от 1 до 6.
     *
     * @required true
     * @var null|Vat[]
     */
    private null|array $vats = null;
    /**
     * ФИО кассира. Максимальная длина строки – 64 символа.
     *
     * @required false
     * @tagFFD   1021 Кассир
     */
    private null|string $cashier = null;
    /**
     * Заводской номер автоматического устройства для расчетов. От 1 до 20 символов.
     * В случае, если параметр не будет передан, в чеке будет указан внутренний номер кассы в сервисе АТОЛ Онлайн
     *
     * @required false
     * @tagFFD   1036 № автомата
     */
    private null|string $device_number = null;

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(null|Company $company): Correction
    {
        $this->company = $company;

        return $this;
    }

    public function getCorrectionInfo(): ?CorrectionInfo
    {
        return $this->correction_info;
    }

    public function setCorrectionInfo(null|CorrectionInfo $correction_info): Correction
    {
        $this->correction_info = $correction_info;

        return $this;
    }

    public function getPayments(): null|array
    {
        return $this->payments;
    }


    /**
     * @param $payments Payment[]
     */
    public function setPayments(null|array $payments): Correction
    {
        $this->payments = $payments;

        return $this;
    }

    public function getVats(): null|array
    {
        return $this->vats;
    }

    /**
     * @param $vats Vat[]
     */
    public function setVats(null|array $vats): Correction
    {
        $this->vats = $vats;

        return $this;
    }

    public function getCashier(): null|string
    {
        return $this->cashier;
    }

    public function setCashier(null|string $cashier): Correction
    {
        $this->cashier = $cashier;

        return $this;
    }

    public function getDeviceNumber(): null|string
    {
        return $this->device_number;
    }

    public function setDeviceNumber(null|string $device_number): Correction
    {
        $this->device_number = $device_number;

        return $this;
    }
}
