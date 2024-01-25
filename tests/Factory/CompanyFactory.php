<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Tests\Factory;

use stdClass;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Company;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class CompanyFactory extends TestCase
{
    /**
     * @return array{entity: Company}
     */
    public function fromEnv(): array
    {
        return [
            'entity' => (new Company())
                ->setEmail(getenv('ATOL_EMAIL'))
                ->setSno(getenv('ATOL_SNO'))
                ->setPaymentAddress(getenv('ATOL_PAYMENT_ADDRESS'))
                ->setLocation(getenv('ATOL_LOCATION'))
                ->setInn(getenv('ATOL_INN')),
        ];
    }

    /**
     * @param string $fileName
     *
     * @return array{entity: Company, object: stdClass}
     */
    public function fromJson(string $fileName): array
    {
        $json = file_get_contents(__DIR__ . '/../../data/samples/item/' . $fileName);

        return [
            'entity' =>
                $this->getAtolApiClient()->getSerializer()->deserialize(
                    data: $json,
                    type: Company::class,
                    format: JsonEncoder::FORMAT
                ),
            'object' => json_decode($json),
        ];
    }
}
