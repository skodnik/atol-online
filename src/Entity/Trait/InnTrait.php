<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity\Trait;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait InnTrait
{
    /**
     * ИНН оператора перевода.
     * Максимальная длина строки – 12 символов.
     *
     * @required false
     * @tagFFD   1016 ИНН оператора перевода
     * @tagFFD   1018 ИНН пользователя
     * @tagFFD   1225 Наименование поставщика
     * @tagFFD   1228 ИНН организации или покупателя (клиента)
     */
    private null|string $inn = null;

    public function getInn(): null|string
    {
        return $this->inn;
    }

    public function setInn(null|string $inn): static
    {
        $this->inn = $inn;

        return $this;
    }
}
