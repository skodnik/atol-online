<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Tests\Factory;

use stdClass;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Error;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ErrorFactory extends TestCase
{
    /**
     * @param string $fileName
     *
     * @return array{entity: Error, object: stdClass}
     */
    public function fromJson(string $fileName): array
    {
        $json = file_get_contents(__DIR__ . '/../../data/samples/item/' . $fileName);

        return [
            'entity' =>
                $this->getAtolApiClient()->getSerializer()->deserialize(
                    data: $json,
                    type: Error::class,
                    format: JsonEncoder::FORMAT
                ),
            'object' => json_decode($json),
        ];
    }
}
