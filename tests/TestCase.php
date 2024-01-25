<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Vlsv\AtolOnline\AtolAccount;
use Vlsv\AtolOnline\AtolApiClient;
use Vlsv\AtolOnline\Cache\SimpleFileCachePsr16;
use Vlsv\AtolOnline\Observer\DebugObserver;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class TestCase extends PHPUnitTestCase
{
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    protected function getAtolAccount(): AtolAccount
    {
        return new AtolAccount(
            host: getenv('ATOL_TEST_HOST'),
            serviceVersion: getenv('ATOL_SERVICE_VERSION'),
            company: getenv('ATOL_COMPANY'),
            inn: getenv('ATOL_INN'),
            groupCode: getenv('ATOL_GROUP_CODE'),
            login: getenv('ATOL_LOGIN'),
            password: getenv('ATOL_PASSWORD'),
            email: getenv('ATOL_EMAIL'),
            sno: getenv('ATOL_SNO'),
            debug: (bool)getenv('ATOL_DEBUG'),
        );
    }

    protected function getAtolApiClient(bool $withCache = false): AtolApiClient
    {
        $atolApiClient = new AtolApiClient(
            atolAccount: $this->getAtolAccount(),
        );

        if ($withCache) {
            $atolApiClient->setCache(new SimpleFileCachePsr16());
        }

        if ($this->getAtolAccount()->isDebug()) {
            $atolApiClient->attach(new DebugObserver());
        }

        return $atolApiClient;
    }
}
