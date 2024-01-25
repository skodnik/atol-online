<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Trait;

use Vlsv\AtolOnline\Entity\Client;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait NameTrait
{
    /**
     * Наименование покупателя (клиента).
     * Максимальная длина строки – 64/128/256 символов.
     *
     * @required true/false
     * @tagFFD   1026 Наименование оператора перевода
     * @tagFFD   1030 Наименование предмета расчета
     * @tagFFD   1085 Наименование дополнительного реквизита пользователя
     * @tagFFD   1227 Наименование организации или фамилия, имя, отчество (при наличии), серия и номер паспорта
     *           покупателя (клиента)
     */
    private null|string $name = null;

    public function getName(): null|string
    {
        return $this->name;
    }

    public function setName(null|string $name): Client
    {
        $this->name = $name;

        return $this;
    }
}
