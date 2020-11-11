<?php

namespace App\Presentation\Protocols;

interface ControllerInterface
{
  public function handle(HttpRequestInterface $request): HttpResponseInterface;
}
