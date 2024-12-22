<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Api\Trait;

use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Enum\OperationType;
use Vlsv\AtolOnline\Entity\Request\Request;
use Vlsv\AtolOnline\Entity\Response\Response;
use Vlsv\AtolOnline\Exception\ApiException;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait OperationTrait
{
    /**
     * Регистрация документа.
     *
     * @see API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 14
     */
    public function operation(
        OperationType $operationType,
        Request $body,
        bool $updateTokenIfExpired = true,
        null|string $token = null,
    ): Response {
        $request = new \GuzzleHttp\Psr7\Request(
            method: 'POST',
            uri: $this->getAtolAccount()->getOperationUrl() . '/' . $operationType->value,
        );

        try {
            $operationResponse = $this->request($request, $body, $token ?? $this->getToken()->getToken());

            $response =  $this->serializeResponse($operationResponse->getBody()->getContents());
        } catch (ApiException $exception) {
            $response = $this->serializeResponse($exception->getResponseBody());

            if ($updateTokenIfExpired && $response->getError()?->isExpiredToken()) {
                $response = $this->serializeResponse($this->retryOperationRequest($request, $body));
            }
        }

        return $response;
    }

    /**
     * Повторное выполнение запроса.
     *
     * @throws InvalidArgumentException
     */
    private function retryOperationRequest($request, $body): string
    {
        try {
            $response = $this->request($request, $body, $this->getToken(removeTokenFromCache: true)->getToken());
            $body = $response->getBody()->getContents();
        } catch (ApiException $exception) {
            $body = $exception->getResponseBody();
        }

        return $body;
    }

    /**
     * Сериализация строки в объект ответа сервера.
     */
    private function serializeResponse(string $responseBody): Response
    {
        return $this->serializer->deserialize(
            data: $responseBody,
            type: Response::class,
            format: JsonEncoder::FORMAT
        );
    }
}
