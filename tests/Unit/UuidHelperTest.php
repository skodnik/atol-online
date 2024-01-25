<?php

declare(strict_types=1);

namespace Unit;

use Vlsv\AtolOnline\Helper\UuidHelper;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class UuidHelperTest extends TestCase
{
    public function validUuidProvider(): array
    {
        return [
            ['550e8400-e29b-41d4-a716-446655440000'],
            ['123e4567-e89b-12d3-a456-426614174001'],
        ];
    }

    public function invalidUuidProvider(): array
    {
        return [
            ['not-a-uuid'],
            ['12345'],
            ['123e4567-e89b-12d3-a456-4266141740011'],
        ];
    }

    /**
     * @group        unit
     * @dataProvider validUuidProvider
     */
    public function testIsValidUuid(string $uuid)
    {
        $this->assertTrue(UuidHelper::isUuid($uuid));
    }

    /**
     * @group        unit
     * @dataProvider invalidUuidProvider
     */
    public function testIsInvalidUuid(string $invalidUuid)
    {
        $this->assertFalse(UuidHelper::isUuid($invalidUuid));
    }
}
