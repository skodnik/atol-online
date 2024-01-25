<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Helper;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class UuidHelper
{
    public static function isUuid(string $string): bool
    {
        $uuidPattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

        return (bool)preg_match($uuidPattern, $string);
    }
}
