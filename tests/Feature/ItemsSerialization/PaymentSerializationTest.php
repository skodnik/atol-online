<?php

declare(strict_types=1);

namespace Feature\ItemsSerialization;

use Vlsv\AtolOnline\Entity\Payment;
use Vlsv\AtolOnline\Tests\Factory\PaymentFactory;
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
    public function testVatSerialization()
    {
        ['entity' => $payment, 'object' => $object] = (new PaymentFactory())->fromJson('payment.json');

        self::assertInstanceOf(Payment::class, $payment);

        self::assertEquals($object->type, $payment->getType()->value);
        self::assertEquals($object->sum, $payment->getSum());
    }
}
