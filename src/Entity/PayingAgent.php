<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Trait\PhonesTrait;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongStringLength;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Атрибуты платежного агента.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 20
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class PayingAgent implements ApiEntityInterface
{
    use PhonesTrait;

    /**
     * Наименование операции.
     * Максимальная длина строки – 24 символа.
     *
     * @required false
     * @tagFFD   1044 Операция платежного агента
     */
    private null|string $operation = null;

    public function getOperation(): null|string
    {
        return $this->operation;
    }

    /**
     * @throws ApiExceptionWrongStringLength
     */
    public function setOperation(null|string $operation): PayingAgent
    {
        if (mb_strlen($operation) > 24) {
            throw new ApiExceptionWrongStringLength(message: 'Operation to long');
        }

        $this->operation = $operation;

        return $this;
    }
}
