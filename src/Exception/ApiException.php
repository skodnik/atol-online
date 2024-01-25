<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Exception;

use Exception;
use Psr\Http\Message\RequestInterface;
use Throwable;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ApiException extends Exception
{
    public function __construct(
        protected ?RequestInterface $request = null,
        protected ?Throwable $previous = null,
        protected array $requestOptions = [],
        protected string $requestBody = '',
        protected string $responseBody = '',
        protected $message = '',
        protected $code = 0,
        protected null|int $duration = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getRequest(): ?RequestInterface
    {
        return $this->request;
    }

    public function getRequestBody(): string
    {
        return $this->requestBody;
    }

    public function getResponseBody(): string
    {
        return $this->responseBody;
    }

    public function getDuration(): null|int
    {
        return $this->duration;
    }
}
