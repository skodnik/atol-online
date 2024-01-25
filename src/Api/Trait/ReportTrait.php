<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Api\Trait;

use GuzzleHttp\Psr7\Request as PSRRequest;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\Response\Report;
use Vlsv\AtolOnline\Exception\ApiException;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait ReportTrait
{
    /**
     * @throws InvalidArgumentException
     */
    public function report(string $uuid, string $token = null, bool $updateTokenIfExpired = true): Report
    {
        $resourcePath = '/report/' . $uuid;

        $request = new PSRRequest(
            method: 'GET',
            uri: $this->getAtolAccount()->getOperationUrl() . $resourcePath,
        );

        try {
            $reportResponse = $this->request(request: $request, token: $token ?? $this->getToken()->getToken());

            $report =  $this->serializeReport($reportResponse->getBody()->getContents());
        } catch (ApiException $exception) {
            $report = $this->serializeReport($exception->getResponseBody());

            if ($updateTokenIfExpired && $report->getError()?->getCode() === 11) {
                $report = $this->serializeReport($this->retryReportRequest($request));
            }
        }

        return $report;
    }

    /**
     * Повторное выполнение запроса.
     *
     * @throws InvalidArgumentException
     */
    private function retryReportRequest($request): string
    {
        try {
            $response = $this->request(request: $request, token: $this->getToken()->getToken());
            $body = $response->getBody()->getContents();
        } catch (ApiException $exception) {
            $body = $exception->getResponseBody();
        }

        return $body;
    }

    public function serializeReport(string $responseBody): Report
    {
        return $this->serializer->deserialize(
            data: $responseBody,
            type: Report::class,
            format: JsonEncoder::FORMAT
        );
    }
}
