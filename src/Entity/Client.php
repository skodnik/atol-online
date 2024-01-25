<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Trait\InnTrait;
use Vlsv\AtolOnline\Entity\Trait\NameTrait;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongStringLength;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Атрибуты клиента.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 18
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Client implements ApiEntityInterface
{
    use NameTrait;
    use InnTrait;

    /**
     * Электронная почта покупателя.
     * Максимальная длина строки – 64 символа. В запросе обязательно
     * должно быть заполнено хотя бы одно из полей: email или phone.
     *
     * @required true
     * @tagFFD   1008̋ Телефон или электронный адрес покупателя
     */
    private null|string $email = null;

    /**
     * Телефон покупателя.
     * Номер телефона необходимо передать вместе с кодом страны без пробелов и дополнительных символов,
     * кроме символа «+» (номер «+371 2 1234567» необходимо передать как «+37121234567»).
     * Если номер телефона относится к России (префикс «+7»), то значение можно передать без префикса
     * (номер «+7 925 1234567» можно передать как «9251234567»).
     * Максимальная длина строки – 64 символа. В запросе обязательно
     * должно быть заполнено хотя бы одно из полей: email или phone.
     *
     * @required true
     * @tagFFD   1008̋ Телефон или электронный адрес покупателя
     */
    private null|string $phone = null;

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setName(null|string $name): Client
    {
        if (mb_strlen($name) > 256) {
            throw new ApiExceptionWrongStringLength(message: 'Name is too long, acceptable max 256 characters');
        }

        $this->name = $name;

        return $this;
    }

    public function getEmail(): null|string
    {
        return $this->email;
    }

    public function setEmail(null|string $email): Client
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): null|string
    {
        return $this->phone;
    }

    public function setPhone(null|string $phone): Client
    {
        $this->phone = $phone;

        return $this;
    }
}
