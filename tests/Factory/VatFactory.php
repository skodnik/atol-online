<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Tests\Factory;

use stdClass;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Vat;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class VatFactory extends TestCase
{
    /**
     * @param string $fileName
     *
     * @return array{entity: Vat, object: stdClass}
     */
    public function fromJson(string $fileName): array
    {
        $json = file_get_contents(__DIR__ . '/../../data/samples/item/' . $fileName);

        return [
            'entity' =>
                $this->getAtolApiClient()->getSerializer()->deserialize(
                    data: $json,
                    type: Vat::class,
                    format: JsonEncoder::FORMAT
                ),
            'object' => json_decode($json),
        ];
    }
}
