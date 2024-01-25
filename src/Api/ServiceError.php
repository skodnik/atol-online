<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Api;

use ReflectionClass;

/**
 * Ошибки сервиса.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 63
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ServiceError extends StatusErrorConstants
{
    /**
     * Код состояния HTTPS.
     */
    private null|int $httpsCode;

    /**
     * Код ошибки.
     */
    private int $code;

    /**
     * Ошибка.
     */
    private null|string $error;

    /**
     * Описание.
     */
    private string $description;

    /**
     * Устранение ошибки.
     */
    private string $troubleshooting;

    /**
     * Тип ошибки.
     */
    private string $type;

    /**
     * Статус.
     */
    private null|string $status;

    private function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $propertyName = lcfirst(str_replace('_', '', ucwords($key, '_')));
            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $value;
            }
        }
    }

    /**
     * Метод для получения информации об ошибке по её коду.
     */
    public static function getErrorByCodeAndType(int $errorCode, string $type): ServiceError
    {
        $constants = (new ReflectionClass(__CLASS__))->getConstants();

        foreach ($constants as $constant) {
            if ($constant['code'] === $errorCode && $constant['type'] === $type) {
                return new ServiceError($constant);
            }
        }

        return new ServiceError(self::UNDEFINED_ERROR);
    }

    public function getHttpsCode(): null|int
    {
        return $this->httpsCode;
    }

    public function setHttpsCode(null|int $httpsCode): self
    {
        $this->httpsCode = $httpsCode;

        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getError(): null|string
    {
        return $this->error;
    }

    public function setError(null|string $error): self
    {
        $this->error = $error;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTroubleshooting(): string
    {
        return $this->troubleshooting;
    }

    public function setTroubleshooting(string $troubleshooting): self
    {
        $this->troubleshooting = $troubleshooting;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
