<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class AtolAccount
{
    public function __construct(
        protected string $host,
        protected string $serviceVersion,
        protected string $company,
        protected string $inn,
        protected string $addr,
        protected string $groupCode,
        protected string $login,
        protected string $password,
        protected string $email,
        protected string $sno,
        protected bool $debug = false,
    ) {
    }

    public function setHost(string $host): AtolAccount
    {
        $this->host = $host;

        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getUrl(): string
    {
        return $this->getHost() . '/' . $this->getServiceVersion();
    }

    public function getOperationUrl(): string
    {
        return $this->getHost() . '/' . $this->getServiceVersion() . '/' . $this->getGroupCode();
    }

    public function setServiceVersion(string $serviceVersion): AtolAccount
    {
        $this->serviceVersion = $serviceVersion;

        return $this;
    }

    public function getServiceVersion(): string
    {
        return $this->serviceVersion;
    }

    public function setCompany(string $company): AtolAccount
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setInn(string $inn): AtolAccount
    {
        $this->inn = $inn;

        return $this;
    }

    public function getInn(): string
    {
        return $this->inn;
    }

    public function setAddr(string $addr): AtolAccount
    {
        $this->addr = $addr;

        return $this;
    }

    public function getAddr(): string
    {
        return $this->addr;
    }

    public function setGroupCode(string $groupCode): AtolAccount
    {
        $this->groupCode = $groupCode;

        return $this;
    }

    public function getGroupCode(): string
    {
        return $this->groupCode;
    }

    public function setLogin(string $login): AtolAccount
    {
        $this->login = $login;

        return $this;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setPassword(string $password): AtolAccount
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setEmail(string $email): AtolAccount
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setSno(string $sno): AtolAccount
    {
        $this->sno = $sno;

        return $this;
    }

    public function getSno(): string
    {
        return $this->sno;
    }

    public function setDebug(bool $debug): AtolAccount
    {
        $this->debug = $debug;

        return $this;
    }

    public function isDebug(): bool
    {
        return $this->debug;
    }
}
