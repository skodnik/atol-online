<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Trait\InnTrait;
use Vlsv\AtolOnline\Entity\Trait\NameTrait;
use Vlsv\AtolOnline\Entity\Trait\PhonesTrait;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Атрибуты поставщика.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 21
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class SupplierInfo implements ApiEntityInterface
{
    use PhonesTrait;
    use NameTrait;
    use InnTrait;
}
