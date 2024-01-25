<?php

declare(strict_types=1);

namespace Unit;

use Vlsv\AtolOnline\Helper\UrlHelper;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class UrlHelperTest extends TestCase
{
    public function correctUrlsProvider(): array
    {
        return [
            ['http://example.com'],
            ['https://www.example.com/path'],
            ['http://localhost:8080/page'],
            ['https://sub.domain.com'],
            ['http://example.com/?test=test'],
        ];
    }

    public function incorrectUrlsProvider(): array
    {
        return [
            ['invalid-url'],
            ['ftp://example.com'],
            ['htp://example.com'],
            ['http://.com'],

            // Не учитываются правилом валидации
            // ['http://example.'],
            // ['http://example..com'],
        ];
    }

    /**
     * @group        unit
     * @dataProvider correctUrlsProvider
     */
    public function testValidUrl($url)
    {
        $result = UrlHelper::isValid($url);
        $this->assertTrue($result);
    }

    /**
     * @group        unit
     * @dataProvider incorrectUrlsProvider
     */
    public function testInvalidUrl($url)
    {
        $result = UrlHelper::isValid($url);
        $this->assertFalse($result);
    }
}
