<?php

declare(strict_types=1);

namespace Feature\ItemsSerialization;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Company;
use Vlsv\AtolOnline\Tests\Factory\CompanyFactory;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class CompanySerializationTest extends TestCase
{
    /**
     * @group feature
     */
    public function testCompanySerialization()
    {
        $serializer = $this->getAtolApiClient()->getSerializer();

        ['entity' => $company] = (new CompanyFactory())->fromEnv();

        self::assertEquals(getenv('ATOL_EMAIL'), $company->getEmail());
        self::assertEquals(getenv('ATOL_SNO'), $company->getSno());
        self::assertEquals(getenv('ATOL_PAYMENT_ADDRESS'), $company->getPaymentAddress());
        self::assertEquals(getenv('ATOL_LOCATION'), $company->getLocation());

        $jsonExpected = json_encode([
            'email' => getenv('ATOL_EMAIL'),
            'sno' => getenv('ATOL_SNO'),
            'payment_address' => getenv('ATOL_PAYMENT_ADDRESS'),
            'location' => getenv('ATOL_LOCATION'),
            'inn' => getenv('ATOL_INN'),
        ]);
        $json = $serializer->serialize($company, JsonEncoder::FORMAT);

        self::assertJson($json);
        self::assertJsonStringEqualsJsonString($jsonExpected, $json);
    }

    /**
     * @group feature
     */
    public function testCompanyFromJsonSerialization()
    {
        ['entity' => $company, 'object' => $object] = (new CompanyFactory())->fromJson('company.json');

        self::assertInstanceOf(Company::class, $company);
        self::assertEquals($object->email, $company->getEmail());
    }
}
