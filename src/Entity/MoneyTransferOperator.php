<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Trait\InnTrait;
use Vlsv\AtolOnline\Entity\Trait\NameTrait;
use Vlsv\AtolOnline\Entity\Trait\PhonesTrait;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongStringLength;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Атрибуты оператора перевода.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 21
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class MoneyTransferOperator implements ApiEntityInterface
{
    use PhonesTrait;
    use NameTrait;
    use InnTrait;

    /**
     * Адрес оператора перевода.
     * Максимальная длина строки – 256 символов
     *
     * @required false
     * @tagFFD   1005 Адрес оператора перевода
     */
    private null|string $address = null;

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setName(null|string $name): static
    {
        if (mb_strlen($name) > 64) {
            throw new ApiExceptionWrongStringLength(message: 'Name is too long, acceptable max 64 characters');
        }

        $this->name = $name;

        return $this;
    }

    public function getAddress(): null|string
    {
        return $this->address;
    }

    public function setAddress(null|string $address): MoneyTransferOperator
    {
        $this->address = $address;

        return $this;
    }
}
