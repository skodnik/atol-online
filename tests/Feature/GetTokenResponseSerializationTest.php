<?php

declare(strict_types=1);

namespace Feature;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Response\GetTokenResponse;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class GetTokenResponseSerializationTest extends TestCase
{
    /**
     * @group feature
     */
    public function testErrorSerialization()
    {
        $getTokenResponse = $this->getAtolApiClient()->getSerializer()->deserialize(
            data: file_get_contents(__DIR__ . '/../../data/samples/response/getTokenResponseSuccess.json'),
            type: GetTokenResponse::class,
            format: JsonEncoder::FORMAT
        );

        self::assertInstanceOf(GetTokenResponse::class, $getTokenResponse);
        self::assertEquals('9hXZNo8FFAgm0wAu8J_SbI_S0Be6wp8Bfh0M76DpY2Bxzj3HLmRjqHtcbz6W2ZkmGV3gMioyHlyqorD5P7wjy0GrdWENkgGIuCRm86W-TBT1J_py4vr8ZTcRmoV9IDqj', $getTokenResponse->getToken());
        self::assertEquals('24.01.2024 21:04:27', $getTokenResponse->getTimestamp()->format('d.m.Y H:i:s'));

        $error = $getTokenResponse->getError();

        self::assertNull($error);
    }
}
