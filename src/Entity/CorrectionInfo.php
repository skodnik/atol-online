<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Enum\CorrectionType;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Коррекция.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 37
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class CorrectionInfo implements ApiEntityInterface
{
    /**
     * Тип коррекции.
     *
     * @required true
     * @tagFFD   1173 Тип коррекции
     */
    private null|CorrectionType $type = null;

    /**
     * Дата документа основания для коррекции в формате: «dd.mm.yyyy».
     *
     * @required true
     * @tagFFD   1178 Дата документа основания для коррекции
     */
    private null|string $base_date = null;

    /**
     * Номер документа основания для коррекции.
     *
     * @required true
     * @tagFFD   1179 Номер документа основания для коррекции
     */
    private null|string $base_number = null;

    public function getType(): ?CorrectionType
    {
        return $this->type;
    }

    public function setType(?CorrectionType $type): CorrectionInfo
    {
        $this->type = $type;

        return $this;
    }

    public function getBaseDate(): ?string
    {
        return $this->base_date;
    }

    public function setBaseDate(?string $base_date): CorrectionInfo
    {
        $this->base_date = $base_date;

        return $this;
    }

    public function getBaseNumber(): ?string
    {
        return $this->base_number;
    }

    public function setBaseNumber(?string $base_number): CorrectionInfo
    {
        $this->base_number = $base_number;

        return $this;
    }
}
