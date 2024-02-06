<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Enum\PaymentMethod;
use Vlsv\AtolOnline\Entity\Enum\PaymentObject;
use Vlsv\AtolOnline\Entity\Trait\ExciseTrait;
use Vlsv\AtolOnline\Entity\Trait\NameTrait;
use Vlsv\AtolOnline\Entity\Trait\PriceTrait;
use Vlsv\AtolOnline\Entity\Trait\QuantityTrait;
use Vlsv\AtolOnline\Entity\Trait\SumTrait;
use Vlsv\AtolOnline\Exception\ApiExceptionOutOfRangeNumber;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongNomenclatureCode;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongStringLength;
use Vlsv\AtolOnline\Helper\NomenclatureCodeHelper;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Атрибуты позиций.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 22
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Item implements ApiEntityInterface
{
    use NameTrait;
    use PriceTrait;
    use SumTrait;
    use QuantityTrait;
    use ExciseTrait;

    /**
     * Единица измерения товара, работы, услуги, платежа, выплаты, иного предмета расчета.
     * Максимальная длина строки – 16 символов.
     *
     * @required false
     * @tagFFD   1197 Единица измерения предмета расчета
     */
    private null|string $measurement_unit = null;

    /**
     * Код товара в шестнадцатеричном представлении с пробелами.
     * Максимальная длина – 32 байта.
     *
     * @required false
     * @tagFFD   1162 Код товара
     */
    private null|string $nomenclature_code = null;

    /**
     * Признак способа расчёта.
     *
     * @required false Если признак не передан, по умолчанию используется значение «full_prepayment».
     * @tagFFD   1214 Признак способа расчета
     */
    private null|PaymentMethod $payment_method = null;

    /**
     * Признак предмета расчёта.
     *
     * @required false Нет Если признак не передан, по умолчанию используется значение «commodity».
     * @tagFFD   1212 Признак предмета расчета
     */
    private null|PaymentObject $payment_object = null;

    /**
     * Атрибуты налога на позицию. Необходимо передать либо сумму налога на позицию, либо сумму налога на чек.
     * Если будут переданы и сумма налога на позицию и сумма налога на чек, сервис учтет только сумму налога на чек.
     *
     * @required true Нет Если признак не передан, по умолчанию используется значение «commodity».
     */
    private null|Vat $vat = null;

    /**
     * Атрибуты агента. Если объект не передан, по умолчанию флаг агента не устанавливается.
     *
     * @required false
     */
    private null|AgentInfo $agent_info = null;

    /**
     * Атрибуты платежного агента.
     *
     * @required false
     */
    private null|PayingAgent $paying_agent = null;

    /**
     * Атрибуты оператора по приему платежей.
     *
     * @required false
     */
    private null|ReceivePaymentsOperator $receive_payments_operator = null;

    /**
     * Атрибуты оператора перевода.
     *
     * @required false
     */
    private null|MoneyTransferOperator $money_transfer_operator = null;

    /**
     * Атрибуты поставщика.
     *
     * @required false Поле обязательно, если передан «agent_info».
     */
    private null|SupplierInfo $supplier_info = null;

    /**
     * Дополнительный реквизит предмета расчета.
     * Максимальная длина строки – 64 символа.
     *
     * @required false
     * @tagFFD   1191 Дополнительный реквизит предмета расчета
     */
    private null|string $user_data = null;

    /**
     * Цифровой код страны происхождения товара • ровно 3 цифры.
     * Если переданный код страны происхождения имеет длину меньше 3 цифр, то он дополняется справа пробелами
     *
     * @required false
     * @tagFFD   1230 Цифровой код страны происхождения товара в соответствии с Общероссийским классификатором стран
     *           мира
     */
    private null|string $country_code = null;

    /**
     * Номер таможенной декларации в соответствии с форматом, установленным приказом ФНС России от
     * 24.03.2016 N ММВ-7- 15/155@ "Об утверждении формата счета-фактуры и формата представления документа
     * об отгрузке товаров (выполнении работ), передаче имущественных прав (документа об оказании услуг),
     * включающего в себя счет- фактуру, в электронной форме" (зарегистрирован Министерством юстиции Российской
     * Федерации
     * 21.04.2016, регистрационный номер 41888, Официальный интернет-портал правовой информации
     * http://www.pravo.gov.ru,
     * 26.04.2016)
     * Максимум 32 символа.
     *
     * @required false
     * @tagFFD   1231
     */
    private null|string $declaration_number = null;

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setName(null|string $name): static
    {
        if (mb_strlen($name) > 128) {
            throw new ApiExceptionWrongStringLength(message: 'Name is too long, acceptable max 128 characters');
        }

        $this->name = $name;

        return $this;
    }

    public function getMeasurementUnit(): null|string
    {
        return $this->measurement_unit;
    }

    /**
     * @throws ApiExceptionOutOfRangeNumber
     */
    public function setMeasurementUnit(null|string $measurement_unit): Item
    {
        if (mb_strlen($measurement_unit) > 16 || mb_strlen($measurement_unit) < 0) {
            throw new ApiExceptionOutOfRangeNumber(message: 'MeasurementUnit wrong length, max: 16, min: 0');
        }

        $this->measurement_unit = $measurement_unit;

        return $this;
    }

    public function getNomenclatureCode(): null|string
    {
        return $this->nomenclature_code;
    }

    /**
     * @throws ApiExceptionWrongNomenclatureCode
     */
    public function setNomenclatureCode(null|string $nomenclature_code): static
    {
        if (NomenclatureCodeHelper::isHexadecimalAndRightLength(
            $nomenclature_code
        ) || NomenclatureCodeHelper::isGS1DataMatrixProductCode($nomenclature_code)) {
            $this->nomenclature_code = $nomenclature_code;

            return $this;
        }

        throw new ApiExceptionWrongNomenclatureCode(message: 'Wrong nomenclature code');
    }

    public function getPaymentMethod(): null|PaymentMethod
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(null|PaymentMethod $payment_method): static
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getPaymentObject(): null|PaymentObject
    {
        return $this->payment_object;
    }

    public function setPaymentObject(null|PaymentObject $payment_object): static
    {
        $this->payment_object = $payment_object;

        return $this;
    }

    public function getVat(): null|Vat
    {
        return $this->vat;
    }

    public function setVat(null|Vat $vat): static
    {
        $this->vat = $vat;

        return $this;
    }

    public function getAgentInfo(): null|AgentInfo
    {
        return $this->agent_info;
    }

    public function setAgentInfo(null|AgentInfo $agent_info): static
    {
        $this->agent_info = $agent_info;

        return $this;
    }

    public function getPayingAgent(): null|PayingAgent
    {
        return $this->paying_agent;
    }

    public function setPayingAgent(null|PayingAgent $paying_agent): Item
    {
        $this->paying_agent = $paying_agent;

        return $this;
    }

    public function getReceivePaymentsoperator(): null|ReceivePaymentsOperator
    {
        return $this->receive_payments_operator;
    }

    public function setReceivePaymentsoperator(null|ReceivePaymentsOperator $receive_payments_operator): Item
    {
        $this->receive_payments_operator = $receive_payments_operator;

        return $this;
    }

    public function getMoneyTransferoperator(): null|MoneyTransferOperator
    {
        return $this->money_transfer_operator;
    }

    public function setMoneyTransferoperator(null|MoneyTransferOperator $money_transfer_operator): Item
    {
        $this->money_transfer_operator = $money_transfer_operator;

        return $this;
    }

    public function getUserData(): null|string
    {
        return $this->user_data;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setUserData(null|string $user_data): Item
    {
        if (mb_strlen($user_data) > 64) {
            throw new ApiExceptionWrongStringLength(message: 'Name is too long, acceptable max 64 characters');
        }

        $this->user_data = $user_data;

        return $this;
    }

    public function getCountryCode(): null|string
    {
        return $this->country_code;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setCountryCode(null|string $country_code): Item
    {
        if (mb_strlen($country_code) !== 3) {
            throw new ApiExceptionWrongStringLength(message: 'CountryCode wrong');
        }

        $this->country_code = $country_code;

        return $this;
    }

    public function getDeclarationNumber(): null|string
    {
        return $this->declaration_number;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setDeclarationNumber(null|string $declaration_number): Item
    {
        if (mb_strlen($declaration_number) > 32) {
            throw new ApiExceptionWrongStringLength(message: 'DeclarationNumber is too long, max: 32 characters');
        }

        $this->declaration_number = $declaration_number;

        return $this;
    }
}
