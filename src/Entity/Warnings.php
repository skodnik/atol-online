<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

/**
 * Важная информация.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 43
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Warnings
{
    /**
     * Имеет значение «callback_url не соответствует маске». Отображается в случае,
     * если значение параметра callback_url в запросе на регистрацию документа было указано некорректно.
     */
    private null|string $callback_url = null;

    public function getCallbackUrl(): null|string
    {
        return $this->callback_url;
    }

    public function setCallbackUrl(null|string $callback_url): Warnings
    {
        $this->callback_url = $callback_url;

        return $this;
    }
}
