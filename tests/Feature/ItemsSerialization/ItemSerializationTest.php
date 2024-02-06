<?php

declare(strict_types=1);

namespace Feature\ItemsSerialization;

use Vlsv\AtolOnline\Entity\Item;
use Vlsv\AtolOnline\Tests\Factory\ItemFactory;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ItemSerializationTest extends TestCase
{
    /**
     * @group feature
     */
    public function testVatSerialization()
    {
        ['entity' => $item, 'object' => $object] = (new ItemFactory())->fromJson('item.json');

        self::assertInstanceOf(Item::class, $item);

        self::assertEquals($object->name, $item->getName());
        self::assertEquals($object->price, $item->getPrice());
        self::assertEquals($object->quantity, $item->getQuantity());
        self::assertEquals($object->sum, $item->getSum());
        self::assertEquals($object->measurement_unit, $item->getMeasurementUnit());
        self::assertEquals($object->payment_method, $item->getPaymentMethod()->value);
        self::assertEquals($object->payment_object, $item->getPaymentObject()->value);
    }
}
