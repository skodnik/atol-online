<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Entity\Enum\AgentType;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Атрибуты клиента.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 19
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class AgentInfo implements ApiEntityInterface
{
    /**
     * Признак агента (ограничен агентами, введенными в ККТ при фискализации).
     *
     * @required false Если передан объект «agent_info», в нём обязательно должно быть передано поле «type».
     * @tagFFD   1057 Признак агента
     */
    private null|AgentType $agentType = null;

    /**
     * Атрибуты платежного агента.
     *
     * @required false
     */
    private null|PayingAgent $payingAgent = null;

    /**
     * Атрибуты оператора перевода.
     *
     * @required false
     */
    private null|ReceivePaymentsOperator $receivePaymentsOperator = null;

    /**
     * Атрибуты оператора перевода.
     *
     * @required false
     */
    private null|MoneyTransferOperator $moneyTransferOperator = null;
}
