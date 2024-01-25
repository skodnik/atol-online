<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Api\ServiceError;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Описание ошибки.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 39
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Error implements ApiEntityInterface
{
    /**
     * Код ошибки. Отображается только при ошибке. Если параметр
     * присутствует, то со значением «fail» или «wait».
     */
    private null|int $code = null;

    /**
     * Уникальный идентификатор ошибки.
     */
    private null|string $error_id = null;

    /**
     * Текст ошибки (кодировка utf–8).
     */
    private null|string $text = null;

    /**
     * Тип источника ошибки. Возможные значения:
     * • «system» – системная ошибка;
     * • «unknown» – неизвестная ошибка.
     */
    private null|string $type = null;

    public function getCode(): null|int
    {
        return $this->code;
    }

    public function setCode(null|int $code): Error
    {
        $this->code = $code;

        return $this;
    }

    public function getErrorId(): null|string
    {
        return $this->error_id;
    }

    public function setErrorId(null|string $error_id): Error
    {
        $this->error_id = $error_id;

        return $this;
    }

    public function getText(): null|string
    {
        return $this->text;
    }

    public function getType(): null|string
    {
        return $this->type;
    }

    public function setType(null|string $type): Error
    {
        $this->type = $type;

        return $this;
    }

    public function getServiceError(): ServiceError
    {
        return ServiceError::getErrorByCodeAndType($this->getCode(), $this->getType());
    }

    public function isExpiredToken(): null|bool
    {
        return $this->getServiceError()->getError() === 'ExpiredToken';
    }

    public function isUndefinedError(): null|bool
    {
        return $this->getServiceError()->getError() === 'Undefined';
    }

    public function isIncomingChequeProcessingFailed(): null|bool
    {
        return $this->getServiceError()->getError() === 'IncomingChequeProcessingFailed';
    }

    public function isMissingToken(): null|bool
    {
        return $this->getServiceError()->getError() === 'MissingToken';
    }

    public function isWrongLoginOrPassword(): null|bool
    {
        return $this->getServiceError()->getError() === 'WrongLoginOrPassword';
    }

    public function isValidationException(): null|bool
    {
        return $this->getServiceError()->getError() === 'ValidationException';
    }

    public function isUserBlocked(): null|bool
    {
        return $this->getServiceError()->getError() === 'UserBlocked';
    }

    public function isGroupCodeAndTokenDontMatch(): null|bool
    {
        return $this->getServiceError()->getError() === 'GroupCodeAndTokenDontMatch';
    }

    public function isNotSupportedGroupCodeForProtocol(): null|bool
    {
        return $this->getServiceError()->getError() === 'NotSupportedGroupCodeForProtocol';
    }

    public function isMissingUuid(): null|bool
    {
        return $this->getServiceError()->getError() === 'MissingUuid';
    }

    public function isIncomingOperationNotSupported(): null|bool
    {
        return $this->getServiceError()->getError() === 'IncomingOperationNotSupported';
    }

    public function isIncomingValidationException(): null|bool
    {
        return $this->getServiceError()->getError() === 'IncomingValidationException';
    }

    public function isIncomingExternalIdAlreadyExists(): null|bool
    {
        return $this->getServiceError()->getError() === 'IncomingExternalIdAlreadyExists';
    }

    public function isStateCheckNotFound(): null|bool
    {
        return $this->getServiceError()->getError() === 'StateCheckNotFound';
    }

    public function isBadRequest(): null|bool
    {
        return $this->getServiceError()->getError() === 'BadRequest';
    }

    public function isUnsupportedMediaType(): null|bool
    {
        return $this->getServiceError()->getError() === 'UnsupportedMediaType';
    }

    public function isErrorServerConfiguration(): null|bool
    {
        return $this->getServiceError()->getError() === 'ErrorServerConfiguration';
    }

    public function isTimeoutFail(): null|bool
    {
        return $this->getServiceError()->getError() === 'timeout' && $this->getServiceError()->getError() === 'fail';
    }
}
