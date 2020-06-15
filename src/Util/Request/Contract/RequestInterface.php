<?php

declare(strict_types=1);

namespace App\Util\Request\Contract;

interface RequestInterface
{
    public function call(string $method, $url): bool;

    public function getHttpCode(): ?int;
}
