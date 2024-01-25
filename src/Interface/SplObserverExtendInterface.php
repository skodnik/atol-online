<?php

namespace Vlsv\AtolOnline\Interface;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SplObserver;
use SplSubject;
use Vlsv\AtolOnline\Api\Status;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
interface SplObserverExtendInterface extends SplObserver
{
    public function update(
        SplSubject $subject,
        int $status = Status::INIT,
        null|RequestInterface $request = null,
        null|array $requestOptions = null,
        null|string|ResponseInterface $response = null,
        null|int $duration = null,
    ): void;
}
