<?php

namespace App\Presentation\Exceptions;

use Exception;

class InvalidParamException extends Exception
{
  public function __construct(string $paramName)
  {
    parent::__construct("Invalid param: $paramName", 400);
  }
}
