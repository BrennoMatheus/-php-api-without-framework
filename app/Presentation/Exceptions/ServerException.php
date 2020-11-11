<?php

namespace App\Presentation\Exceptions;

use Exception;

class ServerException extends Exception
{
  public function __construct()
  {
    parent::__construct("Server Exception", 500);
  }
}
