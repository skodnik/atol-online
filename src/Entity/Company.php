<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Trait\InnTrait;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Атрибуты компании.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 18
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Company implements ApiEntityInterface
{
    use InnTrait;

    /**
     * Электронная почта отправителя чека. Максимальная длина строки – 64 символа.
     *
     * @required true
     * @tagFFD   1117 Адрес электронной почты отправителя чека
     */
    private null|string $email = null;

    /**
     * Система налогообложения. Перечисление со значениями:
     * • «osn» – общая СН;
     * • «usn_income» – упрощенная СН (доходы);
     * • «usn_income_outcome» – упрощенная СН (доходы минус расходы);
     * • «envd» – единый налог на вмененный доход;
     * • «esn» – единый сельскохоз;
     * • «patent» – патентная СН.
     *
     * @required Поле необязательно, если у организации один тип налогообложения.
     * @tagFFD   1055 Применяемая система налогообложения
     */
    private null|string $sno = null;

    /**
     * Место расчетов.
     * Максимальная длина строки – 256 символов.
     *
     * @required true
     * @tagFFD   1187 Место расчетов
     */
    private null|string $payment_address = null;

    /**
     * Адрес расчетов.
     * Длина строки от 1 до 256 символов В случае отсутствия параметра, в чеке будет указан
     * адрес ЦОД, где физически расположена касса.
     *
     * @required false
     * @tagFFD   1009 Адрес расчетов
     */
    private null|string $location = null;

    public function getEmail(): null|string
    {
        return $this->email;
    }

    public function setEmail(null|string $email): Company
    {
        $this->email = $email;

        return $this;
    }

    public function getSno(): null|string
    {
        return $this->sno;
    }

    public function setSno(null|string $phone): Company
    {
        $this->sno = $phone;

        return $this;
    }

    public function getPaymentAddress(): null|string
    {
        return $this->payment_address;
    }

    public function setPaymentAddress(null|string $payment_address): Company
    {
        $this->payment_address = $payment_address;

        return $this;
    }

    public function getLocation(): null|string
    {
        return $this->location;
    }

    public function setLocation(null|string $location): Company
    {
        $this->location = $location;

        return $this;
    }
}
