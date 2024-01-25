<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Tests\Factory;

use stdClass;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Item;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ItemsFactory extends TestCase
{
    /**
     * @param string $fileName
     *
     * @return array{entity: Item, object: stdClass}
     */
    public function fromJson(string $fileName): array
    {
        $json = file_get_contents(__DIR__ . '/../../data/samples/item/' . $fileName);

        $array = json_decode($json, true);

        $units = [];
        foreach ($array as $unit) {
            $units[] =
                $this->getAtolApiClient()->getSerializer()->deserialize(
                    data: json_encode($unit),
                    type: Item::class,
                    format: JsonEncoder::FORMAT
                );
        }

        return $units;
    }
}
