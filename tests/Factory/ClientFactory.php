<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Tests\Factory;

use stdClass;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Client;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongStringLength;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ClientFactory extends TestCase
{
    /**
     * @throws ApiExceptionWrongStringLength
     * @return array{entity: Client}
     */
    public function fromEnv(): array
    {
        return [
            'entity' => (new Client())
                ->setEmail(getenv('ATOL_EMAIL'))
                ->setPhone(getenv('ATOL_PHONE'))
                ->setName(getenv('ATOL_COMPANY'))
                ->setInn(getenv('ATOL_INN')),
        ];
    }

    /**
     * @param string $fileName
     *
     * @return array{entity: Client, object: stdClass}
     */
    public function fromJson(string $fileName): array
    {
        $json = file_get_contents(__DIR__ . '/../../data/samples/item/' . $fileName);

        return [
            'entity' =>
                $this->getAtolApiClient()->getSerializer()->deserialize(
                    data: $json,
                    type: Client::class,
                    format: JsonEncoder::FORMAT
                ),
            'object' => json_decode($json),
        ];
    }
}
