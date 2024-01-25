<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

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
    private null|AgentInfo $agentInfo = null;

    /**
     * Атрибуты поставщика.
     *
     * @required false Поле обязательно, если передан «agent_info».
     */
    private null|SupplierInfo $supplierInfo = null;

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
    private null|string $additionalCheckProps = null;

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
    private null|AdditionalUserProps $additionalUserProps = null;

    /**
     * Заводской номер автоматического устройства для расчетов.
     * От 1 до 20 символов
     * В случае, если параметр не будет передан, в чеке будет указан внутренний номер кассы в сервисе АТОЛ Онлайн
     *
     * @required false
     * @tagFFD   1036 № автомата
     */
    private null|string $deviceNumber = null;

    /**
     * Рассчитывает и устанавливает сумму чека по всем позициям.
     * Рассчитывает и устанавливает размер налога по каждой позиции чека.
     *
     * @throws ApiExceptionWrongArrayLength
     */
    public function calculate(): static
    {
        // $this->calculateVats();
        $this->calculateTotal();

        return $this;
    }

    /**
     * Рассчитывает и устанавливает сумму чека по всем позициям.
     */
    public function calculateTotal(): static
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item->getSum();
        }

        $this->setTotal($total);

        return $this;
    }

    /**
     * Рассчитывает и устанавливает размер налога по каждой позиции чека.
     * TODO: Требуется доработка, в настоящее время расчет некорректен
     *
     * @throws ApiExceptionWrongArrayLength
     */
    public function calculateVats(): static
    {
        $vats = [];
        foreach ($this->getItems() as $item) {
            $vats[] = (new Vat())
                ->setType($item->getVat()->getType())
                ->setSum(VatHelper::calculateSumByVat($item->getVat()->getType(), $item->getSum()));
        }

        $this->setVats($vats);

        return $this;
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
        return $this->agentInfo;
    }

    public function setAgentInfo(null|AgentInfo $agentInfo): Receipt
    {
        $this->agentInfo = $agentInfo;

        return $this;
    }

    public function getSupplierInfo(): null|SupplierInfo
    {
        return $this->supplierInfo;
    }

    public function setSupplierInfo(null|SupplierInfo $supplierInfo): Receipt
    {
        $this->supplierInfo = $supplierInfo;

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

    public function getAdditionalCheckProps(): null|string
    {
        return $this->additionalCheckProps;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setAdditionalCheckProps(null|string $additionalCheckProps): Receipt
    {
        if (mb_strlen($additionalCheckProps) > 16) {
            throw new ApiExceptionWrongStringLength(
                message: 'AdditionalCheckProps is too long, acceptable max 16 characters'
            );
        }

        $this->additionalCheckProps = $additionalCheckProps;

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

    public function getAdditionalUserProps(): null|AdditionalUserProps
    {
        return $this->additionalUserProps;
    }

    public function setAdditionalUserProps(null|AdditionalUserProps $additionalUserProps): Receipt
    {
        $this->additionalUserProps = $additionalUserProps;

        return $this;
    }

    public function getDeviceNumber(): null|string
    {
        return $this->deviceNumber;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setDeviceNumber(null|string $deviceNumber): Receipt
    {
        if (mb_strlen($deviceNumber) > 20 || mb_strlen($deviceNumber) < 1) {
            throw new ApiExceptionWrongStringLength(message: 'DeviceNumber is too long, acceptable max 20 characters');
        }

        $this->deviceNumber = $deviceNumber;

        return $this;
    }
}
