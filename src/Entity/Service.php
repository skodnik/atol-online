<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Entity;

use Vlsv\AtolOnline\Exception\ApiExceptionWrongUrl;
use Vlsv\AtolOnline\Helper\UrlHelper;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * Служебный раздел.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 17
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class Service implements ApiEntityInterface
{
    /**
     * URL, на который необходимо ответить после обработки документа.
     * Максимальная длина строки – 256 символов.
     *
     * Если поле заполнено корректно, то после обработки документа (успешной или не успешной
     * фискализации в ККТ: статус «done» или «fail»), ответ будет отправлен POST запросом по URL
     * указанному в данном поле.
     *
     * @required false
     * @tagFFD   -
     */
    private null|string $callback_url = null;

    public function getCallbackUrl(): null|string
    {
        return $this->callback_url;
    }

    /**
     * @throws ApiExceptionWrongUrl
     */
    public function setCallbackUrl(?string $callbackUrl): Service
    {
        if (!UrlHelper::isValid($callbackUrl)) {
            throw new ApiExceptionWrongUrl(message: 'Wrong url: ' . $callbackUrl);
        }

        $this->callback_url = $callbackUrl;

        return $this;
    }
}
