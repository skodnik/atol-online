<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Observer;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SplSubject;
use Throwable;
use Vlsv\AtolOnline\Api\Status;
use Vlsv\AtolOnline\Interface\SplObserverExtendInterface;

/**
 * Пример для клиента.
 *
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class DebugObserver implements SplObserverExtendInterface
{
    public function update(
        SplSubject $subject,
        int $status = Status::INIT,
        null|RequestInterface $request = null,
        null|array $requestOptions = null,
        null|string|ResponseInterface $response = null,
        null|int $duration = null,
    ): void {
        try {
            $message = $response ? $response->getBody()->getContents() : '';
        } catch (Throwable) {
            $message = $response;
        }

        $date = date('Y-m-d_H:i:s');

        $tmpDebugPath = './data/tmp/debug/' . $date . '_';
        $tmpLogsPath = './data/tmp/jsons/' . $date . '_';

        $headers = '';
        foreach ($requestOptions['headers'] as $name => $value) {
            $headers .= $name . ': ' . $value . PHP_EOL;
        }

        $requestBody = $requestOptions['body'] ?? '';
        $requestHttp = '### ' . $request->getUri()->getPath() . ' ' . $request->getMethod() . PHP_EOL .
            $request->getMethod() . ' ' .
            $request->getUri() . PHP_EOL .
            $headers . PHP_EOL .
            $requestBody;

        // Store request
        file_put_contents(
            $tmpDebugPath . 'request_' . basename($request->getUri()->getPath()) . '.http',
            $requestHttp
        );

        // Store request
        file_put_contents(
            $tmpLogsPath . 'request_' . basename($request->getUri()->getPath()) . '.json',
            $requestBody
        );

        // Store response
        file_put_contents(
            $tmpLogsPath . 'response_' . basename($request->getUri()->getPath()) . '_' . $duration . 'ms.json',
            $message
        );
    }
}
