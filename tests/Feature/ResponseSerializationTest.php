<?php

declare(strict_types=1);

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Error;
use Vlsv\AtolOnline\Entity\Response\Response;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ResponseSerializationTest extends TestCase
{
    /**
     * @group feature
     */
    public function testResponseSuccessSerialization()
    {
        $json = file_get_contents(__DIR__ . '/../../data/samples/response/responseSuccess.json');
        $object = json_decode($json);

        /** @var Response $response */
        $response = $this->getAtolApiClient()->getSerializer()->deserialize(
            data: $json,
            type: Response::class,
            format: JsonEncoder::FORMAT
        );

        self::assertInstanceOf(Response::class, $response);
        self::assertEquals($object->uuid, $response->getUuid());
        self::assertEquals($object->timestamp, $response->getTimestamp()->format('d.m.Y H:i:s'));
        self::assertEquals($object->status, $response->getStatus());

        $error = $response->getError();

        self::assertNull($error);
    }

    /**
     * @group feature
     */
    public function testResponseFailSerialization()
    {
        $json = file_get_contents(__DIR__ . '/../../data/samples/response/responseFail.json');
        $object = json_decode($json);

        /** @var Response $response */
        $response = $this->getAtolApiClient()->getSerializer()->deserialize(
            data: $json,
            type: Response::class,
            format: JsonEncoder::FORMAT
        );

        self::assertInstanceOf(Response::class, $response);
        self::assertNull($response->getUuid());
        self::assertEquals($object->timestamp, $response->getTimestamp()->format('d.m.Y H:i:s'));
        self::assertEquals($object->status, $response->getStatus());

        $error = $response->getError();

        self::assertInstanceOf(Error::class, $error);
        self::assertEquals($object->error->code, $error->getCode());
        self::assertEquals($object->error->error_id, $error->getErrorId());
        self::assertEquals($object->error->text, $error->getText());
        self::assertEquals($object->error->type, $error->getType());
    }
}
