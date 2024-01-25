<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Trait\NameTrait;
use Vlsv\AtolOnline\Exception\ApiExceptionOutOfRangeNumber;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Дополнительный реквизит пользователя.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 33
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class AdditionalUserProps implements ApiEntityInterface
{
    use NameTrait;

    /**
     * Значение дополнительного реквизита пользователя.
     * Максимальная длина строки – 256 символов.
     *
     * @required false Если передан объект «additional_user_props », в нём обязательно должно быть передано поле
     *           «value».
     * @tagFFD   1086 Значение дополнительного реквизита пользователя
     */
    private null|string $value = null;

    public function getValue(): null|string
    {
        return $this->value;
    }

    /**
     * @throws ApiExceptionOutOfRangeNumber
     */
    public function setValue(null|string $value): AdditionalUserProps
    {
        if ($value > 256 || $value < 0) {
            throw new ApiExceptionOutOfRangeNumber(message: 'Value out of range, max: 256, min: 0');
        }

        $this->value = $value;

        return $this;
    }
}
