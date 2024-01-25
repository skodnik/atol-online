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
    private null|string $measurementUnit = null;

    /**
     * Код товара в шестнадцатеричном представлении с пробелами.
     * Максимальная длина – 32 байта.
     *
     * @required false
     * @tagFFD   1162 Код товара
     */
    private null|string $nomenclatureCode = null;

    /**
     * Признак способа расчёта.
     *
     * @required false Если признак не передан, по умолчанию используется значение «full_prepayment».
     * @tagFFD   1214 Признак способа расчета
     */
    private null|PaymentMethod $paymentMethod = null;

    /**
     * Признак предмета расчёта.
     *
     * @required false Нет Если признак не передан, по умолчанию используется значение «commodity».
     * @tagFFD   1212 Признак предмета расчета
     */
    private null|PaymentObject $paymentObject = null;

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
    private null|AgentInfo $agentInfo = null;

    /**
     * Атрибуты платежного агента.
     *
     * @required false
     */
    private null|PayingAgent $payingAgent = null;

    /**
     * Атрибуты оператора по приему платежей.
     *
     * @required false
     */
    private null|ReceivePaymentsOperator $receivePaymentsOperator = null;

    /**
     * Атрибуты оператора перевода.
     *
     * @required false
     */
    private null|MoneyTransferOperator $moneyTransferOperator = null;

    /**
     * Атрибуты поставщика.
     *
     * @required false Поле обязательно, если передан «agent_info».
     */
    private null|SupplierInfo $supplierInfo = null;

    /**
     * Дополнительный реквизит предмета расчета.
     * Максимальная длина строки – 64 символа.
     *
     * @required false
     * @tagFFD   1191 Дополнительный реквизит предмета расчета
     */
    private null|string $userData = null;

    /**
     * Цифровой код страны происхождения товара • ровно 3 цифры.
     * Если переданный код страны происхождения имеет длину меньше 3 цифр, то он дополняется справа пробелами
     *
     * @required false
     * @tagFFD   1230 Цифровой код страны происхождения товара в соответствии с Общероссийским классификатором стран
     *           мира
     */
    private null|string $countryCode = null;

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
    private null|string $declarationNumber = null;

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
        return $this->measurementUnit;
    }

    /**
     * @throws ApiExceptionOutOfRangeNumber
     */
    public function setMeasurementUnit(null|string $measurementUnit): Item
    {
        if (mb_strlen($measurementUnit) > 16 || mb_strlen($measurementUnit) < 0) {
            throw new ApiExceptionOutOfRangeNumber(message: 'MeasurementUnit wrong length, max: 16, min: 0');
        }

        $this->measurementUnit = $measurementUnit;

        return $this;
    }

    public function getNomenclatureCode(): null|string
    {
        return $this->nomenclatureCode;
    }

    /**
     * @throws ApiExceptionWrongNomenclatureCode
     */
    public function setNomenclatureCode(null|string $nomenclatureCode): static
    {
        if (NomenclatureCodeHelper::isHexadecimalAndRightLength(
            $nomenclatureCode
        ) || NomenclatureCodeHelper::isGS1DataMatrixProductCode($nomenclatureCode)) {
            $this->nomenclatureCode = $nomenclatureCode;

            return $this;
        }

        throw new ApiExceptionWrongNomenclatureCode(message: 'Wrong nomenclature code');
    }

    public function getPaymentMethod(): null|PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(null|PaymentMethod $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getPaymentObject(): null|PaymentObject
    {
        return $this->paymentObject;
    }

    public function setPaymentObject(null|PaymentObject $paymentObject): static
    {
        $this->paymentObject = $paymentObject;

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
        return $this->agentInfo;
    }

    public function setAgentInfo(null|AgentInfo $agentInfo): static
    {
        $this->agentInfo = $agentInfo;

        return $this;
    }

    public function getPayingAgent(): null|PayingAgent
    {
        return $this->payingAgent;
    }

    public function setPayingAgent(null|PayingAgent $payingAgent): Item
    {
        $this->payingAgent = $payingAgent;

        return $this;
    }

    public function getReceivePaymentsOperator(): null|ReceivePaymentsOperator
    {
        return $this->receivePaymentsOperator;
    }

    public function setReceivePaymentsOperator(null|ReceivePaymentsOperator $receivePaymentsOperator): Item
    {
        $this->receivePaymentsOperator = $receivePaymentsOperator;

        return $this;
    }

    public function getMoneyTransferOperator(): null|MoneyTransferOperator
    {
        return $this->moneyTransferOperator;
    }

    public function setMoneyTransferOperator(null|MoneyTransferOperator $moneyTransferOperator): Item
    {
        $this->moneyTransferOperator = $moneyTransferOperator;

        return $this;
    }

    public function getUserData(): null|string
    {
        return $this->userData;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setUserData(null|string $userData): Item
    {
        if (mb_strlen($userData) > 64) {
            throw new ApiExceptionWrongStringLength(message: 'Name is too long, acceptable max 64 characters');
        }

        $this->userData = $userData;

        return $this;
    }

    public function getCountryCode(): null|string
    {
        return $this->countryCode;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setCountryCode(null|string $countryCode): Item
    {
        if (mb_strlen($countryCode) !== 3) {
            throw new ApiExceptionWrongStringLength(message: 'CountryCode wrong');
        }

        $this->countryCode = $countryCode;

        return $this;
    }

    public function getDeclarationNumber(): null|string
    {
        return $this->declarationNumber;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setDeclarationNumber(null|string $declarationNumber): Item
    {
        if (mb_strlen($declarationNumber) > 32) {
            throw new ApiExceptionWrongStringLength(message: 'DeclarationNumber is too long, max: 32 characters');
        }

        $this->declarationNumber = $declarationNumber;

        return $this;
    }
}
