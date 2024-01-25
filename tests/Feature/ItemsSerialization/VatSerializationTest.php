<?php

declare(strict_types=1);

namespace Feature\ItemsSerialization;

use Vlsv\AtolOnline\Entity\Enum\VatType;
use Vlsv\AtolOnline\Entity\Vat;
use Vlsv\AtolOnline\Tests\Factory\VatFactory;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class VatSerializationTest extends TestCase
{
    /**
     * @group feature
     */
    public function testVatSerialization()
    {
        ['entity' => $vat, 'object' => $object] = (new VatFactory())->fromJson('vat.json');

        self::assertInstanceOf(Vat::class, $vat);

        $vatType = $vat->getType();

        self::assertInstanceOf(VatType::class, $vatType);
        self::assertEquals($object->type, $vatType->value);
        self::assertNull($vat->getSum());
    }
}
