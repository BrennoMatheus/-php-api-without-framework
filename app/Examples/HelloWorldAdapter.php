<?php

namespace App\Examples;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HelloWorldAdapter
{
  private $helloWorld;

  public function __construct(HelloWorld $helloWorld)
  {
    $this->helloWorld = $helloWorld;
  }

  public function __invoke(ServerRequestInterface $request): ResponseInterface
  {
    $res = $this->helloWorld->handle($request);
    return new JsonResponse($res, 200);
  }
}
