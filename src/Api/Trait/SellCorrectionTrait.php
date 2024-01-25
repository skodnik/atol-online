<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Api\Trait;

use Psr\SimpleCache\InvalidArgumentException;
use Vlsv\AtolOnline\Entity\Enum\OperationType;
use Vlsv\AtolOnline\Entity\Request\Request;
use Vlsv\AtolOnline\Entity\Response\Response;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait SellCorrectionTrait
{
    /**
     * Регистрация документа.
     * sell_correction: чек «Коррекция прихода»
     *
     * @see API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 14
     * @throws InvalidArgumentException
     */
    public function sellCorrection(Request $body, string $token = null, bool $updateTokenIfExpired = true): Response
    {
        return $this->operation(
            operationType: OperationType::SELL_CORRECTION,
            body: $body,
            updateTokenIfExpired: $updateTokenIfExpired,
            token: $token
        );
    }
}
