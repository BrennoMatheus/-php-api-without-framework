<?php

namespace App\Presentation\Http;

use App\Presentation\Protocols\HttpRequestInterface;

class HttpRequest implements HttpRequestInterface
{
    private array $body;

    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public function all(): array
    {
        return $this->body;
    }
}
