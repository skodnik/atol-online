<?php

declare(strict_types=1);

namespace Integration;

use Psr\SimpleCache\InvalidArgumentException;
use Throwable;
use Vlsv\AtolOnline\Exception\ApiException;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class GetTokenTest extends TestCase
{
    /**
     * @group integration
     * @throws ApiException
     * @throws InvalidArgumentException
     */
    public function testGetTokenSuccess()
    {
        $atolApiClient = $this->getAtolApiClient();
        $getTokenResponse = $atolApiClient->getToken(false);

        self::assertIsString($getTokenResponse->getToken());
        self::assertNotEmpty($getTokenResponse->getToken());
        self::assertEmpty($getTokenResponse->getError());
    }

    /**
     * @group integration
     * @throws ApiException
     * @throws InvalidArgumentException
     */
    public function testGetTokenWithCacheSuccess()
    {
        $atolApiClient = $this->getAtolApiClient(true);
        $cache = $atolApiClient->getCache();
        $cacheKey = $atolApiClient->getCacheKey();

        if ($cache->has($cacheKey)) {
            $cache->delete($cacheKey);
        }

        self::assertFalse($cache->has($cacheKey));

        $getTokenResponse = $atolApiClient->getToken();

        self::assertIsString($getTokenResponse->getToken());
        self::assertNotEmpty($getTokenResponse->getToken());
        self::assertEmpty($getTokenResponse->getError());

        self::assertTrue($cache->has($cacheKey));

        $getTokenResponse = $atolApiClient->getToken();

        self::assertIsString($getTokenResponse->getToken());
        self::assertNotEmpty($getTokenResponse->getToken());
        self::assertEmpty($getTokenResponse->getError());

        $cache->delete($cacheKey);
        self::assertFalse($cache->has($cacheKey));
    }

    /**
     * @group integration
     */
    public function testGetTokenException()
    {
        $atolApiClient = $this->getAtolApiClient();
        $atolAccount = $atolApiClient->getAtolAccount();
        $atolAccount = $atolAccount->setLogin('wrong login');
        $atolApiClient = $atolApiClient->setAtolAccount($atolAccount);

        try {
            $getTokenResponse = $atolApiClient->getToken();
        } catch (Throwable $exception) {
            self::assertInstanceOf(ApiException::class, $exception);

            self::assertIsString($exception->getResponseBody());
            self::assertNotEmpty($exception->getResponseBody());
        }
    }
}
