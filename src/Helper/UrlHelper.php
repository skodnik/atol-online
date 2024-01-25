<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Helper;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class UrlHelper
{
    /**
     * Корректность заполненного поля определяется по регулярному выражению:
     * ^http(s?)\:\/\/[0-9a-zA-Zа-яА-Я]([-.\w]*[0-9a-zA-Zа-яА-Я])*(:(0-9)*)*(\/?)([a-zA-Z0-9а-яА-Я\-\.\?\,\'\/\\\+&=%\$#_]*)?$
     *
     * @see API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 18,
     */
    public static function isValid(string $url): bool
    {
        $urlPattern = '/^http(s?)\:\/\/[0-9a-zA-Zа-яА-Я]([-.\w]*[0-9a-zA-Zа-яА-Я])*(:(0-9)*)*(\/?)([a-zA-Z0-9а-яА-Я\-\.\?\,\'\/\\\+&=%\$#_]*)?$/';

        return (bool)preg_match($urlPattern, $url);
    }
}
