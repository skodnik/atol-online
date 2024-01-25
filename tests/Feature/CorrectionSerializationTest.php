<?php

declare(strict_types=1);

namespace Feature;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Company;
use Vlsv\AtolOnline\Entity\Correction;
use Vlsv\AtolOnline\Entity\CorrectionInfo;
use Vlsv\AtolOnline\Entity\Payment;
use Vlsv\AtolOnline\Entity\Request\RequestCorrection;
use Vlsv\AtolOnline\Entity\Vat;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class CorrectionSerializationTest extends TestCase
{
    /**
     * @group feature
     */
    public function testResponseSuccessSerialization()
    {
        $json = file_get_contents(__DIR__ . '/../../data/samples/request/requestCorrectionIncomeConsumption.json');
        $object = json_decode($json);

        /** @var RequestCorrection $response */
        $requestCorrection = $this->getAtolApiClient()->getSerializer()->deserialize(
            data: $json,
            type: RequestCorrection::class,
            format: JsonEncoder::FORMAT
        );

        self::assertInstanceOf(RequestCorrection::class, $requestCorrection);

        self::assertEquals($object->external_id, $requestCorrection->getExternalId());
        self::assertEquals($object->timestamp, $requestCorrection->getTimestamp()->format('d.m.Y H:i:s'));

        $correction = $requestCorrection->getCorrection();

        self::assertInstanceOf(Correction::class, $correction);

        $company = $correction->getCompany();

        self::assertInstanceOf(Company::class, $company);
        self::assertEquals($object->correction->company->sno, $company->getSno());
        self::assertEquals($object->correction->company->inn, $company->getInn());
        self::assertEquals($object->correction->company->payment_address, $company->getPaymentAddress());

        $correctionInfo = $correction->getCorrectionInfo();

        self::assertInstanceOf(CorrectionInfo::class, $correctionInfo);

        $payments = $correction->getPayments();

        self::assertCount(count($object->correction->payments), $payments);

        foreach ($payments as $key => $payment) {
            self::assertInstanceOf(Payment::class, $payment);
        }

        $vats = $correction->getVats();

        self::assertIsArray($vats);
        self::assertCount(2, $vats);

        foreach ($vats as $key => $vat) {
            self::assertInstanceOf(Vat::class, $vat);
        }
    }
}
