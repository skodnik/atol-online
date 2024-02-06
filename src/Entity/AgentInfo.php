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
    private null|AgentType $agent_type = null;

    /**
     * Атрибуты платежного агента.
     *
     * @required false
     */
    private null|PayingAgent $paying_agent = null;

    /**
     * Атрибуты оператора перевода.
     *
     * @required false
     */
    private null|ReceivePaymentsOperator $receive_payments_operator = null;

    /**
     * Атрибуты оператора перевода.
     *
     * @required false
     */
    private null|MoneyTransferOperator $money_transfer_operator = null;

    public function getAgentType(): null|AgentType
    {
        return $this->agent_type;
    }

    public function setAgentType(null|AgentType $agent_type): AgentInfo
    {
        $this->agent_type = $agent_type;

        return $this;
    }

    public function getPayingAgent(): null|PayingAgent
    {
        return $this->paying_agent;
    }

    public function setPayingAgent(null|PayingAgent $paying_agent): AgentInfo
    {
        $this->paying_agent = $paying_agent;

        return $this;
    }

    public function getReceivePaymentsOperator(): null|ReceivePaymentsOperator
    {
        return $this->receive_payments_operator;
    }

    public function setReceivePaymentsOperator(null|ReceivePaymentsOperator $receive_payments_operator): AgentInfo
    {
        $this->receive_payments_operator = $receive_payments_operator;

        return $this;
    }

    public function getMoneyTransferOperator(): null|MoneyTransferOperator
    {
        return $this->money_transfer_operator;
    }

    public function setMoneyTransferOperator(null|MoneyTransferOperator $money_transfer_operator): AgentInfo
    {
        $this->money_transfer_operator = $money_transfer_operator;

        return $this;
    }
}
