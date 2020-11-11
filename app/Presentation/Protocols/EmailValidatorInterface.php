<?php

namespace App\Presentation\Protocols;

interface EmailValidatorInterface
{
  public function isValid(string $email): bool;
}
