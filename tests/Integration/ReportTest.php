<?php

declare(strict_types=1);

namespace Integration;

use DateTimeImmutable;
use Psr\SimpleCache\InvalidArgumentException;
use Vlsv\AtolOnline\Api\StatusErrorConstants;
use Vlsv\AtolOnline\Entity\Enum\Status;
use Vlsv\AtolOnline\Entity\Error;
use Vlsv\AtolOnline\Entity\Response\Report;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ReportTest extends TestCase
{
    /**
     * @group integration
     * @throws InvalidArgumentException
     */
    public function testReport(): void
    {
        $atolApiClient = $this->getAtolApiClient();
        $uuid = getenv('ATOL_TEST_UUID');

        $report = $atolApiClient->report($uuid);

        self::assertInstanceOf(Report::class, $report);
        self::assertEquals($uuid, $report->getUuid());

        self::assertInstanceOf(DateTimeImmutable::class, $report->getTimestamp());

        $status = $report->getStatus();

        self::assertInstanceOf(Status::class, $status);
    }

    /**
     * @group integration
     * @throws InvalidArgumentException
     */
    public function testReportExpiredToken(): void
    {
        $atolApiClient = $this->getAtolApiClient();
        $uuid = getenv('ATOL_TEST_UUID');

        $report = $atolApiClient->report($uuid, getenv('ATOL_TOKEN_IS_NOT_ACTIVE'), false);

        self::assertNull($report->getUuid());

        $error = $report->getError();

        self::assertInstanceOf(Error::class, $error);

        $serviceError = $error->getServiceError();

        self::assertEquals(StatusErrorConstants::EXPIRED_TOKEN['error'], $serviceError->getError());
    }

    /**
     * @group integration
     * @throws InvalidArgumentException
     */
    public function testReportExpiredTokenAndUpdateToken(): void
    {
        $atolApiClient = $this->getAtolApiClient();
        $uuid = getenv('ATOL_TEST_UUID');

        $report = $atolApiClient->report($uuid, getenv('ATOL_TOKEN_IS_NOT_ACTIVE'));

        self::assertInstanceOf(Report::class, $report);
        self::assertEquals($uuid, $report->getUuid());

        self::assertInstanceOf(DateTimeImmutable::class, $report->getTimestamp());

        $status = $report->getStatus();

        self::assertInstanceOf(Status::class, $status);
    }
}
