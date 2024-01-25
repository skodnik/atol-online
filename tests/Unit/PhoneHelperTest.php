<?php

declare(strict_types=1);

use Vlsv\AtolOnline\Helper\PhoneHelper;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class PhoneHelperTest extends \Vlsv\AtolOnline\Tests\TestCase
{
    public function inConditionsPhoneNumbersProvider(): array
    {
        return [
            ['+79251234567', '9251234567'],           // Российский номер с префиксом
            ['74155552671', '4155552671'],            // Международный номер с префиксом
            ['89251234567', '9251234567'],            // Российский номер c 8
            ['9251234567', '9251234567'],             // Российский номер без префикса
            ['14155552671', '14155552671'],            // Международный номер без префикса
            ['+7925123456789', '925123456789'],       // Слишком длинный российский номер
            ['+141555526718999', '+141555526718999'], // Слишком длинный международный номер
            ['+123 456 789', '+123456789'],           // Пробелы в номере
        ];
    }

    public function outOfConditionsPhoneNumbersProvider(): array
    {
        return [
            ['123456'],     // Слишком короткий номер
            ['+123abc456'], // Недопустимые символы
            ['abc123'],     // Недопустимые символы
        ];
    }

    /**
     * @group        unit
     * @dataProvider inConditionsPhoneNumbersProvider
     */
    public function testInConditionsPhoneNumber($phoneNumber, $cleanedPhoneNumber)
    {
        self::assertTrue((bool)PhoneHelper::inConditions($phoneNumber));
        self::assertEquals($cleanedPhoneNumber, PhoneHelper::inConditions($phoneNumber));
    }

    /**
     * @group        unit
     * @dataProvider outOfConditionsPhoneNumbersProvider
     */
    public function testOutOfConditionsPhoneNumber($phoneNumber)
    {
        self::assertFalse((bool)PhoneHelper::inConditions($phoneNumber));
    }
}
