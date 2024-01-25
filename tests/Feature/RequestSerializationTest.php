<?php

declare(strict_types=1);

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Client;
use Vlsv\AtolOnline\Entity\Company;
use Vlsv\AtolOnline\Entity\Payment;
use Vlsv\AtolOnline\Entity\Receipt;
use Vlsv\AtolOnline\Entity\Request\Request;
use Vlsv\AtolOnline\Entity\Vat;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class RequestSerializationTest extends TestCase
{
    public function requestDataProvider(): array
    {
        $basePath = __DIR__ . '/../../data/samples/request';

        return [
            [$basePath . '/requestIncomeConsumption-01.json', false],
            [$basePath . '/requestIncomeConsumption-02.json', true],
        ];
    }

    /**
     * @group feature
     * @dataProvider requestDataProvider
     */
    public function testRequestSerialization(string $filePath, bool $hasVats)
    {
        $json = file_get_contents($filePath);
        $object = json_decode($json);

        /** @var Request $request */
        $request = $this->getAtolApiClient()->getSerializer()->deserialize(
            data: $json,
            type: Request::class,
            format: JsonEncoder::FORMAT
        );

        self::assertEquals($object->external_id, $request->getExternalId());
        self::assertEquals($object->timestamp, $request->getTimestamp()->format('d.m.Y H:i:s'));

        $receipt = $request->getReceipt();

        self::assertInstanceOf(Receipt::class, $receipt);

        $client = $receipt->getClient();

        self::assertInstanceOf(Client::class, $client);

        $company = $receipt->getCompany();

        self::assertInstanceOf(Company::class, $company);

        self::assertInstanceOf(Company::class, $company);
        self::assertEquals($object->receipt->company->sno, $company->getSno());
        self::assertEquals($object->receipt->company->inn, $company->getInn());
        self::assertEquals($object->receipt->company->payment_address, $company->getPaymentAddress());

        $payments = $receipt->getPayments();

        self::assertCount(count($object->receipt->payments), $payments);

        foreach ($payments as $key => $payment) {
            self::assertInstanceOf(Payment::class, $payment);
        }

        $vats = $receipt->getVats();

        if ($hasVats) {
            self::assertIsArray($vats);
            self::assertCount(count($object->receipt->vats), $vats);

            foreach ($vats as $key => $vat) {
                self::assertInstanceOf(Vat::class, $vat);
            }
        } else {
            self::assertNull($vats);
        }
    }
}
