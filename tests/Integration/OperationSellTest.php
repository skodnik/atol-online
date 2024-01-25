<?php

declare(strict_types=1);

namespace Integration;

use Psr\SimpleCache\InvalidArgumentException;
use Vlsv\AtolOnline\Api\ServiceError;
use Vlsv\AtolOnline\Entity\Error;
use Vlsv\AtolOnline\Entity\Request\Request;
use Vlsv\AtolOnline\Entity\Response\Response;
use Vlsv\AtolOnline\Exception\ApiException;
use Vlsv\AtolOnline\Helper\UuidHelper;
use Vlsv\AtolOnline\Tests\Factory\RequestSellFactory;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class OperationSellTest extends TestCase
{
    /**
     * @group integration
     * @throws InvalidArgumentException
     * @throws ApiException
     */
    public function testSellSuccess()
    {
        $atolApiClient = $this->getAtolApiClient();

        $request = (new RequestSellFactory())->get();

        self::assertInstanceOf(Request::class, $request);

        $response = $atolApiClient->sell($request);

        self::assertInstanceOf(Response::class, $response);

        self::assertIsString($response->getUuid());
        self::assertTrue(UuidHelper::isUuid($response->getUuid()));
        self::assertNull($response->getError());
    }

    /**
     * @group integration
     * @throws InvalidArgumentException
     * @throws ApiException
     */
    public function testSellExpiredToken()
    {
        $atolApiClient = $this->getAtolApiClient();

        $request = (new RequestSellFactory())->get();

        self::assertInstanceOf(Request::class, $request);

        $response = $atolApiClient->sell($request, getenv('ATOL_TOKEN_IS_NOT_ACTIVE'), false);

        self::assertInstanceOf(Response::class, $response);

        $error = $response->getError();

        self::assertInstanceOf(Error::class, $error);

        self::assertTrue($error->isExpiredToken());

        $serviceError = $error->getServiceError();

        self::assertEquals(ServiceError::EXPIRED_TOKEN['error'], $serviceError->getError());
    }

    /**
     * @group integration
     * @throws InvalidArgumentException
     * @throws ApiException
     */
    public function testSellExpiredTokenAndUpdateToken()
    {
        $atolApiClient = $this->getAtolApiClient();

        $request = (new RequestSellFactory())->get();

        self::assertInstanceOf(Request::class, $request);

        $response = $atolApiClient->sell($request, getenv('ATOL_TOKEN_IS_NOT_ACTIVE'));

        self::assertInstanceOf(Response::class, $response);

        self::assertIsString($response->getUuid());
        self::assertTrue(UuidHelper::isUuid($response->getUuid()));
        self::assertNull($response->getError());
    }
}
