<?php

namespace App\Presentation\Protocols;

interface HttpResponseInterface
{
    public function getBody();
    public function getStatusCode(): int;
}
