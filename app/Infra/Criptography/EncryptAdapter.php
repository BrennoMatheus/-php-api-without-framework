<?php

namespace App\Infra\Criptography;

use App\Data\Protocols\EncrypterInterface;

class EncryptAdapter implements EncrypterInterface
{
  public function encrypt(string $string): string
  {
    return password_hash($string, PASSWORD_DEFAULT);
  }
}
