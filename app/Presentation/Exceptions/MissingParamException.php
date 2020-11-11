<?php

namespace App\Presentation\Exceptions;

use Exception;

class MissingParamException extends Exception
{
  public function __construct(string $paramName)
  {
    parent::__construct("Missing param: $paramName", 400);
  }
}
