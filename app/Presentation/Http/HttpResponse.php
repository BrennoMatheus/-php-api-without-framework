<?php

namespace App\Presentation\Http;

use App\Presentation\Protocols\HttpResponseInterface;

class HttpResponse implements HttpResponseInterface
{
    private int $statusCode;
    private $body;

    public function __construct(int $statusCode, $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
