<?php

declare(strict_types=1);

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Service;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongUrl;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ServiceSerializationTest extends TestCase
{
    /**
     * @group feature
     * @throws ApiExceptionWrongUrl
     */
    public function testServiceSerialization()
    {
        $serializer = $this->getAtolApiClient()->getSerializer();

        $service = (new Service())
            ->setCallbackUrl(getenv('ATOL_CALLBACK_URL'));

        self::assertEquals(getenv('ATOL_CALLBACK_URL'), $service->getCallbackUrl());

        $jsonExpected = json_encode(['callback_url' => getenv('ATOL_CALLBACK_URL')]);

        $json = $serializer->serialize($service, JsonEncoder::FORMAT);
        self::assertJson($json);
        self::assertEquals($jsonExpected, $json);
    }

    /**
     * @group feature
     */
    public function testServiceSerializationException()
    {
        try {
            (new Service())->setCallbackUrl('wrong-url');

            self::fail();
        } catch (ApiExceptionWrongUrl $exception) {
            self::assertInstanceOf(ApiExceptionWrongUrl::class, $exception);
        }
    }
}
