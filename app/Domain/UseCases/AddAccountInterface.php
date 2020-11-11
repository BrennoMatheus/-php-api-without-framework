<?php

namespace App\Domain\UseCases;

use App\Domain\Models\Account;

interface AddAccountInterface
{
  public function add(array $data): Account;
}
