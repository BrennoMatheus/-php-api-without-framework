<?php

namespace App\Data\Protocols;

use App\Domain\Models\Account;

interface AddAccountRepositoryInterface
{
  public function add(array $data): Account;
}
