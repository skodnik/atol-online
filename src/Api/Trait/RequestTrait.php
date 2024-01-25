<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Api\Trait;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Throwable;
use Vlsv\AtolOnline\Api\Status;
use Vlsv\AtolOnline\Exception\ApiException;
use Vlsv\AtolOnline\Interface\ApiEntityInterface;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait RequestTrait
{
    /**
     * @throws ApiException
     */
    protected function request(
        Request $request,
        null|ApiEntityInterface $body = null,
        null|string $token = null
    ): ResponseInterface {
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        $token ? $headers['Token'] = $token : null;

        $options = ['headers' => $headers];
        $body ? $options['body'] = $this->serializer->serialize($body, JsonEncoder::FORMAT) : null;

        $duration = -hrtime(true);

        try {
            $response = $this->client->send(
                request: $request,
                options: $options
            );

            $duration += hrtime(true);
            $duration = (int)round($duration / 1e+6);

            $this->notify(
                status: Status::SUCCESS,
                request: $request,
                requestOptions: $options,
                response: $response,
                duration: $duration,
            );

            $response->getBody()->rewind();
        } catch (Throwable $exception) {
            $duration += hrtime(true);
            $duration = (int)round($duration / 1e+6);

            try {
                $responseBody = $exception->getResponse()?->getBody()->getContents();
            } catch (Throwable) {
                $responseBody = '';
            }

            $this->notify(
                status: Status::EXCEPTION,
                request: $request,
                requestOptions: $options,
                response: $responseBody,
                duration: $duration,
            );

            throw new ApiException(
                request: $request,
                previous: $exception,
                requestOptions: $options,
                responseBody: $responseBody,
                duration: $duration,
            );
        }

        return $response;
    }
}
