<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Enum\VatType;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongArrayLength;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongStringLength;
use Vlsv\AtolOnline\Helper\VatHelper;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Чек.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 18
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Receipt implements ApiEntityInterface
{
    /**
     * Атрибуты клиента.
     *
     * @required true
     */
    private null|Client $client = null;

    /**
     * Атрибуты компании.
     *
     * @required true
     */
    private null|Company $company = null;

    /**
     * Атрибуты агента.
     *
     * @required false
     */
    private null|AgentInfo $agent_info = null;

    /**
     * Атрибуты поставщика.
     *
     * @required false Поле обязательно, если передан «agent_info».
     */
    private null|SupplierInfo $supplier_info = null;

    /**
     * Атрибуты позиций. Ограничение по количеству от 1 до 100.
     *
     * @var Item[]
     * @required false Поле обязательно, если передан «agent_info».
     */
    private null|array $items = null;

    /**
     * Оплаты. Ограничение по количеству от 1 до 10.
     *
     * @var Payment[]
     * @required true
     */
    private null|array $payments = null;

    /**
     * Атрибуты налогов на чек. Ограничение по количеству от 1 до 6.
     * Необходимо передать либо сумму налога на позицию, либо сумму налога на чек. Если будет переданы и
     * сумма налога на позицию и сумма налога
     *
     * @var Vat[]
     * @required false
     */
    private null|array $vats = null;

    /**
     * Итоговая сумма чека в рублях с заданным в CMS округлением:
     * • целая часть не более 8 знаков;
     * • дробная часть не более 2 знаков.
     * Сумму чека можно округлить, но не более, чем на 99 копеек.
     * При регистрации в ККТ происходит расчёт фактической суммы: суммирование значений sum позиций.
     *
     * @required true
     * @tagFFD   1020 Сумма расчета, указанного в чеке (БСО)
     */
    private null|int|float $total = null;

    /**
     * Дополнительный реквизит чека.
     * Максимальная длина строки – 16 символов.
     *
     * @required false
     * @tagFFD   1192 Дополнительный реквизит чека (БСО)
     */
    private null|string $additional_check_props = null;

    /**
     * ФИО кассира. Максимальная длина строки – 64 символа.
     *
     * @required false
     * @tagFFD   1021 Кассир
     */
    private null|string $cashier = null;

    /**
     * Дополнительный реквизит пользователя.
     *
     * @required false
     * @tagFFD   1084 Дополнительный реквизит пользователя
     */
    private null|AdditionalUserProps $additional_user_props = null;

    /**
     * Заводской номер автоматического устройства для расчетов.
     * От 1 до 20 символов
     * В случае, если параметр не будет передан, в чеке будет указан внутренний номер кассы в сервисе АТОЛ Онлайн
     *
     * @required false
     * @tagFFD   1036 № автомата
     */
    private null|string $device_number = null;

    /**
     * Рассчитывает и устанавливает сумму чека по всем позициям.
     * Рассчитывает и устанавливает размер налога по каждой позиции чека.
     *
     * @throws ApiExceptionWrongArrayLength
     */
    public function calculateAndSetVatsAndTotal(): static
    {
        $this->setVats($this->calculateVats($this->getItems()));
        $this->setTotal($this->calculateTotal($this->getItems()));

        return $this;
    }

    /**
     * Рассчитывает и устанавливает сумму чека по всем позициям.
     */
    public static function calculateTotal(array $items): int|float
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item->getSum();
        }

        return $total;
    }

    /**
     * Рассчитывает и размер налога по каждой ставке налога.
     *
     * @param Item[] $items
     *
     * @return Vat[]
     */
    public static function calculateVats(array $items): array
    {
        $types = [];
        foreach ($items as $item) {
            @$types[$item->getVat()->getType()->value] += VatHelper::calculateSumByVat($item->getVat()->getType(), $item->getSum());
        }

        $vats = [];
        foreach ($types as $type => $sum) {
            $vatType = VatType::tryFrom($type);
            $vats[] = (new Vat())
                ->setType($vatType)
                ->setSum($sum);
        }

        return $vats;
    }

    public function getClient(): null|Client
    {
        return $this->client;
    }

    public function setClient(null|Client $client): Receipt
    {
        $this->client = $client;

        return $this;
    }

    public function getCompany(): null|Company
    {
        return $this->company;
    }

    public function setCompany(null|Company $company): Receipt
    {
        $this->company = $company;

        return $this;
    }

    public function getAgentInfo(): null|AgentInfo
    {
        return $this->agent_info;
    }

    public function setAgentInfo(null|AgentInfo $agent_info): Receipt
    {
        $this->agent_info = $agent_info;

        return $this;
    }

    public function getSupplierInfo(): null|SupplierInfo
    {
        return $this->supplier_info;
    }

    public function setSupplierInfo(null|SupplierInfo $supplier_info): Receipt
    {
        $this->supplier_info = $supplier_info;

        return $this;
    }

    public function getItems(): null|array
    {
        return $this->items;
    }

    /**
     * @throws ApiExceptionWrongArrayLength
     */
    public function setItems(null|array $items): Receipt
    {
        if (count($items) > 100 || count($items) < 1) {
            throw new ApiExceptionWrongArrayLength(message: 'Wrong items count, max: 100, min: 1');
        }

        $this->items = $items;

        return $this;
    }

    public function getPayments(): null|array
    {
        return $this->payments;
    }

    /**
     * @throws ApiExceptionWrongArrayLength
     */
    public function setPayments(null|array $payments): Receipt
    {
        if (count($payments) > 10 || count($payments) < 1) {
            throw new ApiExceptionWrongArrayLength(message: 'Wrong payments count, max: 10, min: 1');
        }

        $this->payments = $payments;

        return $this;
    }

    public function getVats(): null|array
    {
        return $this->vats;
    }

    /**
     * @throws ApiExceptionWrongArrayLength
     */
    public function setVats(null|array $vats): Receipt
    {
        if (count($vats) > 6 || count($vats) < 1) {
            throw new ApiExceptionWrongArrayLength(message: 'Wrong vats count, max: 10, min: 1');
        }

        $this->vats = $vats;

        return $this;
    }

    public function getTotal(): float|int|null
    {
        return $this->total;
    }

    public function setTotal(float|int|null $total): Receipt
    {
        $this->total = $total;

        return $this;
    }

    public function getAdditionalCheckprops(): null|string
    {
        return $this->additional_check_props;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setAdditionalCheckprops(null|string $additional_check_props): Receipt
    {
        if (mb_strlen($additional_check_props) > 16) {
            throw new ApiExceptionWrongStringLength(
                message: 'AdditionalCheckProps is too long, acceptable max 16 characters'
            );
        }

        $this->additional_check_props = $additional_check_props;

        return $this;
    }

    public function getCashier(): null|string
    {
        return $this->cashier;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setCashier(null|string $cashier): Receipt
    {
        if (mb_strlen($cashier) > 64) {
            throw new ApiExceptionWrongStringLength(message: 'Cashier is too long, acceptable max 64 characters');
        }

        $this->cashier = $cashier;

        return $this;
    }

    public function getAdditionalUserprops(): null|AdditionalUserProps
    {
        return $this->additional_user_props;
    }

    public function setAdditionalUserprops(null|AdditionalUserProps $additional_user_props): Receipt
    {
        $this->additional_user_props = $additional_user_props;

        return $this;
    }

    public function getDeviceNumber(): null|string
    {
        return $this->device_number;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setDeviceNumber(null|string $device_number): Receipt
    {
        if (mb_strlen($device_number) > 20 || mb_strlen($device_number) < 1) {
            throw new ApiExceptionWrongStringLength(message: 'DeviceNumber is too long, acceptable max 20 characters');
        }

        $this->device_number = $device_number;

        return $this;
    }
}
