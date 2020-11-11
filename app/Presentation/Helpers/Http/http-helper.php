<?php

namespace App\Presentation\Helpers\Http;

use App\Presentation\Exceptions\ServerException;
use App\Presentation\Http\HttpResponse;
use Exception;

function badRequest(Exception $exception): HttpResponse
{
  return new HttpResponse(400, ['error' => $exception->getMessage()]);
}

function serverError(): HttpResponse
{
  $exception = new ServerException();
  return new HttpResponse(500, ['error' => $exception->getMessage()]);
}
