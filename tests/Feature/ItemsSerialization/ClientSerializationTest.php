<?php

declare(strict_types=1);

namespace Feature\ItemsSerialization;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Client;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongStringLength;
use Vlsv\AtolOnline\Tests\Factory\ClientFactory;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ClientSerializationTest extends TestCase
{
    /**
     * @group feature
     * @throws ApiExceptionWrongStringLength
     */
    public function testClientSerialization()
    {
        $serializer = $this->getAtolApiClient()->getSerializer();

        ['entity' => $client] = (new ClientFactory())->fromEnv();

        self::assertEquals(getenv('ATOL_EMAIL'), $client->getEmail());
        self::assertEquals(getenv('ATOL_PHONE'), $client->getPhone());
        self::assertEquals(getenv('ATOL_COMPANY'), $client->getName());
        self::assertEquals(getenv('ATOL_INN'), $client->getInn());

        $jsonExpected = json_encode([
            'email' => getenv('ATOL_EMAIL'),
            'phone' => getenv('ATOL_PHONE'),
            'name' => getenv('ATOL_COMPANY'),
            'inn' => getenv('ATOL_INN'),
        ]);
        $json = $serializer->serialize($client, JsonEncoder::FORMAT);

        self::assertJson($json);
        self::assertJsonStringEqualsJsonString($jsonExpected, $json);
    }

    /**
     * @group feature
     */
    public function testClientFromJsonSerialization()
    {
        ['entity' => $client, 'object' => $object] = (new ClientFactory())->fromJson('client.json');

        self::assertInstanceOf(Client::class, $client);
        self::assertEquals($object->email, $client->getEmail());
    }
}
