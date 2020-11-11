<?php

namespace App\Main\Adapters;

use App\Presentation\Http\HttpRequest;
use App\Presentation\Protocols\ControllerInterface;
use Closure;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

function adaptRoute(ControllerInterface $controller): Closure
{
  return function (ServerRequestInterface $request) use ($controller): ResponseInterface {

    $httpRequest = new HttpRequest($request->getParsedBody());

    $httpResponse = $controller->handle($httpRequest);

    return new JsonResponse($httpResponse->getBody(), $httpResponse->getStatusCode());
  };
}
