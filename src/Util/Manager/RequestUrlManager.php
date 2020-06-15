<?php

declare(strict_types=1);

namespace App\Util\Manager;

use App\Util\Request\Contract\RequestInterface;

class RequestUrlManager
{
    /** @var RequestInterface */
    private $httpRequester;

    public function __construct(RequestInterface $request)
    {
        $this->httpRequester = $request;
    }

    public function makeRequest(string $url, $method = 'GET')
    {
        $this->httpRequester->call($method, $url);
    }

    public function getHttpCode(): ?int
    {
        return $this->httpRequester->getHttpCode();
    }
}
