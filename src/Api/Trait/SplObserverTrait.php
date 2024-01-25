<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Api\Trait;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SplObserver;
use Vlsv\AtolOnline\Api\Status;
use Vlsv\AtolOnline\Interface\SplObserverExtendInterface;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
trait SplObserverTrait
{
    /**
     * @param SplObserver $observer
     */
    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    /**
     * @param SplObserver $observer
     */
    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(
        int $status = Status::INIT,
        null|RequestInterface $request = null,
        null|array $requestOptions = null,
        null|string|ResponseInterface $response = null,
        null|int $duration = null,
    ): void {
        /** @var SplObserverExtendInterface $observer */
        foreach ($this->observers as $observer) {
            $observer->update($this, $status, $request, $requestOptions, $response, $duration);
        }
    }
}
