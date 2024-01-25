<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Trait;

use Vlsv\AtolOnline\Exception\ApiExceptionIncorrectPhoneNumber;
use Vlsv\AtolOnline\Helper\PhoneHelper;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait PhonesTrait
{
    /**
     * Телефоны платежного агента.
     * Номер телефона необходимо передать вместе с кодом страны без пробелов и дополнительных символов,
     * кроме символа «+».
     * Если номер телефон начинается с символа «+», то максимальная длина одного элемента массива – 19 символов.
     * Если номер телефона относится к России (префикс «+7»), то значение можно передать без префикса
     * (номер «+7 925 1234567» можно передать как «9251234567»). Максимальная длина одного элемента
     * массива в таком случае – 17 символов.
     *
     * @required false
     * @tagFFD   1073 Телефон платежного агента
     * @tagFFD   1074 Телефон оператора по приему платежей
     * @tagFFD   1075 Телефон оператора перевода
     * @tagFFD   1171 Телефон поставщика
     */
    private null|array $phones = null;

    public function getPhones(): null|array
    {
        return $this->phones;
    }

    /**
     * @throws ApiExceptionIncorrectPhoneNumber
     */
    public function setPhones(null|array $phones): static
    {
        $wrongPhoneNumbers = [];
        foreach ($phones as $phone) {
            if (!PhoneHelper::inConditions($phone)) {
                $wrongPhoneNumbers[] = $phone;
            }
        }

        if ($wrongPhoneNumbers) {
            throw new ApiExceptionIncorrectPhoneNumber(
                message: 'Wrong phone numbers: ' . implode(', ', $wrongPhoneNumbers)
            );
        }

        $this->phones = $phones;

        return $this;
    }
}
