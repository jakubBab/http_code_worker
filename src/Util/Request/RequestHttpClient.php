<?php

declare(strict_types=1);

namespace App\Util\Request;

use App\Util\Request\Contract\RequestInterface;
use Requests;

class RequestHttpClient implements RequestInterface
{
    protected $httpCode;

    public function call(string $method, $url): bool
    {
        try {
            $request = Requests::get($url);
            if ($request->success) {
                $this->httpCode = $request->status_code;
            }
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    public function getHttpCode(): ?int
    {
        return $this->httpCode;
    }
}
