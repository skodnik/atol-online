<?php

declare(strict_types=1);

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Error;
use Vlsv\AtolOnline\Entity\Response\GetTokenResponse;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ErrorSerializationTest extends TestCase
{
    public function getTokenResponseProvider(): array
    {
        $filePaths = [];
        $basePath = __DIR__ . '/../../data/samples/response/';
        $prefix = 'getTokenResponseFail-';

        $files = glob($basePath . $prefix . '*.json');

        foreach ($files as $file) {
            $filePaths[] = [$file];
        }

        return $filePaths;
    }

    /**
     * @group        feature
     * @dataProvider getTokenResponseProvider
     */
    public function testErrorSerialization($samplePath)
    {
        $data = file_get_contents($samplePath);
        $object = json_decode($data);

        $getTokenResponse = $this->getAtolApiClient()->getSerializer()->deserialize(
            data: $data,
            type: GetTokenResponse::class,
            format: JsonEncoder::FORMAT
        );

        self::assertInstanceOf(GetTokenResponse::class, $getTokenResponse);

        $error = $getTokenResponse->getError();

        self::assertInstanceOf(Error::class, $error);
        self::assertEquals($object->error->code, $error->getCode());
        self::assertEquals($object->error->error_id, $error->getErrorId());
        self::assertEquals($object->error->text, $error->getText());
        self::assertEquals($object->error->type, $error->getType());
    }
}
