<?php

namespace App\Presentation\Protocols;

interface ValidatorInterface
{
  public function validate(string $data): bool;
}
