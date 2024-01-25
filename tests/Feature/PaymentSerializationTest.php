<?php

declare(strict_types=1);

namespace Feature;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Enum\PaymentType;
use Vlsv\AtolOnline\Entity\Payment;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class PaymentSerializationTest extends TestCase
{
    /**
     * @group feature
     */
    public function testPaymentSerialization()
    {
        $json = file_get_contents(__DIR__ . '/../../data/samples/item/payment.json');
        $object = json_decode($json);

        /** @var Payment $response */
        $payment = $this->getAtolApiClient()->getSerializer()->deserialize(
            data: $json,
            type: Payment::class,
            format: JsonEncoder::FORMAT
        );

        self::assertInstanceOf(Payment::class, $payment);

        $paymentType = $payment->getType();

        self::assertInstanceOf(PaymentType::class, $paymentType);
        self::assertEquals($object->type, $paymentType->value);
        self::assertEquals($object->sum, $payment->getSum());
    }
}
