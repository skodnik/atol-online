<?php

declare(strict_types=1);

namespace Unit;

use Vlsv\AtolOnline\Helper\NomenclatureCodeHelper;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class NomenclatureCodeHelperTest extends TestCase
{
    public function hexDataProvider(): array
    {
        return [
            ['1A', true],  // позитивный кейс
            ['1E C6 1E C6 1E C6 1E C6 1E C6 1E C6 1E C6 1E C6', true],  // позитивный кейс
            ['invalid', false],  // негативный кейс: не шестнадцатеричное число
            ['1E C6 1E C6 1E C6 1E C6 1E C6 1E C6 1E C6 1E C6 1E C6', false],  // негативный кейс: длина больше 32
        ];
    }

    /**
     * @group        unit
     * @dataProvider hexDataProvider
     */
    public function testIsHexadecimalProductCode($code, $expected)
    {
        $result = NomenclatureCodeHelper::isHexadecimalAndRightLength($code);
        $this->assertEquals($expected, $result);
    }

    public function gs1DataProvider(): array
    {
        return [
            ['010463003407001221CMK45BrhN0WLf', true],
            // позитивный кейс
            ['invalid', false],
            // негативный кейс: не соответствует регулярному выражению
            ['010463003407001221CMK45BrhN0WLfABCDEF010463003407001221CMK45BrhN0WLfABCDEF010463', false],
            // негативный кейс: длина больше 150
        ];
    }

    /**
     * @group        unit
     * @dataProvider gs1DataProvider
     */
    public function testIsGS1DataMatrixProductCode($code, $expected)
    {
        $result = NomenclatureCodeHelper::isGS1DataMatrixProductCode($code);
        $this->assertEquals($expected, $result);
    }
}
