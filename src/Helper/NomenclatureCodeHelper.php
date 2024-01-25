<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Helper;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class NomenclatureCodeHelper
{
    /**
     * Проверяет, соответствует ли переданный код шестнадцатеричному представлению и имеет ли он правильную длину.
     */
    public static function isHexadecimalAndRightLength(string $code): bool
    {
        // Удаляем пробелы из строки.
        $code = str_replace(' ', '', $code);

        // Проверяем, что строка представляет шестнадцатеричное число.
        if (!ctype_xdigit($code)) {
            return false;
        }

        // Проверяем, что длина кода не превышает 32 символов.
        return strlen($code) <= 32;
    }

    /**
     * Проверяет, соответствует ли переданный код товара в формате GS1 Data Matrix
     * заданному шаблону и не превышает заданную длину.
     */
    public static function isGS1DataMatrixProductCode(string $code): bool
    {
        // Удаляем пробелы из строки.
        $code = str_replace(' ', '', $code);

        // Регулярное выражение для проверки корректности кода.
        $pattern = '/^([a-fA-F0-9]{2}$)|(^([a-fA-F0-9]{2}\s){1,31}[a-fA-F0-9]{2}|01(\d{14})21([a-zA-Z0-9!"%&\'()*+\/\-.,:;=<>?_]{13})([a-zA-Z0-9!"%&\'()*+\/\-.,:;=<>?_]{1,119})?|(\d{14})([a-zA-Z0-9!"%&\'()*+\/\-.,:;=<>?_]{11})[a-zA-Z0-9!"%&\'()*+\/\-.,:;=<>?_]{4})$/';

        // Если код не соответствует шаблону, возвращаем false.
        if (preg_match($pattern, $code) !== 1) {
            return false;
        }

        // Преобразуем код в его шестнадцатеричное представление.
        $hexRepresentation = bin2hex($code);

        // Проверяем, что длина шестнадцатеричного представления не превышает 150 символов.
        return strlen($hexRepresentation) <= 150;
    }
}
