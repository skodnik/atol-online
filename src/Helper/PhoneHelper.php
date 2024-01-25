<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Helper;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class PhoneHelper
{
    /**
     * Номер телефона необходимо передать вместе с кодом страны без пробелов и дополнительных символов, кроме символа
     * «+». Если номер телефон начинается с символа «+», то максимальная длина одного элемента массива – 19 символов.
     * Если номер телефона относится к России (префикс «+7»), то значение можно передать без префикса
     * (номер «+7 925 1234567» можно передать как «9251234567»). Максимальная длина одного элемента
     * массива в таком случае – 17 символов.
     */
    public static function inConditions(string $phoneNumber): bool|string
    {
        $cleanedPhoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);
        $cleanedPhoneNumberLength = strlen($cleanedPhoneNumber);

        if ($cleanedPhoneNumberLength > 19 || $cleanedPhoneNumberLength < 10) {
            return false; // Некорректная длина номера
        }

        // Проверка принадлежности номера к России
        if (str_starts_with($cleanedPhoneNumber, '+7')) {
            return substr($cleanedPhoneNumber, 2); // Номер соответствует формату для России
        }

        // Проверка принадлежности номера к России
        if (str_starts_with($cleanedPhoneNumber, '8') || str_starts_with($cleanedPhoneNumber, '7')) {
            return substr($cleanedPhoneNumber, 1); // Номер соответствует формату для России
        }

        return $cleanedPhoneNumber;
    }
}
