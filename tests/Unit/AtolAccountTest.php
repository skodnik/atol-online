<?php

declare(strict_types=1);

namespace Unit;

use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class AtolAccountTest extends TestCase
{
    /**
     * @group unit
     */
    public function testAtolAccount()
    {
        $atolAccount = $this->getAtolAccount();

        $this->assertEquals(getenv('ATOL_TEST_HOST'), $atolAccount->getHost());
        $this->assertEquals(getenv('ATOL_SERVICE_VERSION'), $atolAccount->getServiceVersion());
        $this->assertEquals(getenv('ATOL_COMPANY'), $atolAccount->getCompany());
        $this->assertEquals(getenv('ATOL_INN'), $atolAccount->getInn());
        $this->assertEquals(getenv('ATOL_ADDR'), $atolAccount->getAddr());
        $this->assertEquals(getenv('ATOL_GROUP_CODE'), $atolAccount->getGroupCode());
        $this->assertEquals(getenv('ATOL_LOGIN'), $atolAccount->getLogin());
        $this->assertEquals(getenv('ATOL_PASSWORD'), $atolAccount->getPassword());
        $this->assertEquals(getenv('ATOL_EMAIL'), $atolAccount->getEmail());
        $this->assertEquals(getenv('ATOL_SNO'), $atolAccount->getSno());
        $this->assertEquals((bool)getenv('ATOL_DEBUG'), $atolAccount->isDebug());
    }
}
