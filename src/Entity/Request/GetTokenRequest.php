<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Request;

use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Авторизация пользователя.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 12
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class GetTokenRequest implements ApiEntityInterface
{
    private string $login;
    private string $pass;

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): GetTokenRequest
    {
        $this->login = $login;

        return $this;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    public function setPass(string $pass): GetTokenRequest
    {
        $this->pass = $pass;

        return $this;
    }
}
