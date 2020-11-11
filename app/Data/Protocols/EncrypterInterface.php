<?php

namespace App\Data\Protocols;

interface EncrypterInterface
{
  public function encrypt(string $string): string;
}
