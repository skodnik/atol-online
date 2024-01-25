<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Api\Trait;

use GuzzleHttp\Psr7\Request;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Request\GetTokenRequest;
use Vlsv\AtolOnline\Entity\Response\GetTokenResponse;
use Vlsv\AtolOnline\Exception\ApiException;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait GetTokenTrait
{
    /**
     * @throws ApiException
     * @throws InvalidArgumentException
     */
    public function getToken(bool $withCache = true, bool $removeTokenFromCache = false): GetTokenResponse
    {
        $cacheKey = $this->getCacheKey();

        $removeTokenFromCache ? $this->cache?->delete($cacheKey) : null;

        if ($withCache && $this->cache && $getTokenResponseJson = $this->cache->get($cacheKey)) {
            return $this->deserialize($getTokenResponseJson);
        }

        $resourcePath = '/getToken';

        $request = new Request(
            method: 'POST',
            uri: $this->getAtolAccount()->getUrl() . $resourcePath,
        );

        $requestBody = (new GetTokenRequest())
            ->setLogin($this->getAtolAccount()->getLogin())
            ->setPass($this->getAtolAccount()->getPassword());

        $response = $this->request($request, $requestBody);

        $responseBody = $response->getBody()->getContents();
        $getTokenResponse = $this->deserialize($responseBody);

        if ($withCache && $this->cache && !$getTokenResponse->getError() && $getTokenResponse->getToken()) {
            $this->cache->set(
                key: $cacheKey,
                value: $responseBody,
                ttl: $this->cacheKeyTokenTtlSec,
            );
        }

        return $getTokenResponse;
    }

    private function deserialize(string $json): GetTokenResponse
    {
        return $this->serializer->deserialize(
            data: $json,
            type: GetTokenResponse::class,
            format: JsonEncoder::FORMAT
        );
    }
}
