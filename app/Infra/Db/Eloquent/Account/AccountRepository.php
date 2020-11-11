<?php

namespace App\Infra\Db\Eloquent\Account;

use App\Data\Protocols\AddAccountRepositoryInterface;
use App\Domain\Models\Account;
use App\Infra\Db\Eloquent\Account\Account as AccountEloquent;

class AccountRepository implements AddAccountRepositoryInterface
{
  public function add(array $data): Account
  {
    $account = AccountEloquent::create($data)->toArray();
    return new Account($account);
  }
}
