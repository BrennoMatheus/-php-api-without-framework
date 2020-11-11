<?php

namespace App\Data\UseCases;

use App\Data\Protocols\AddAccountRepositoryInterface;
use App\Data\Protocols\EncrypterInterface;
use App\Domain\Models\Account;
use App\Domain\UseCases\AddAccountInterface;

class DbAddAccount implements AddAccountInterface
{
  private AddAccountRepositoryInterface $addAccountRepository;
  private EncrypterInterface $encrypter;

  public function __construct(
    AddAccountRepositoryInterface $addAccountRepository,
    EncrypterInterface $encrypter
  ) {
    $this->addAccountRepository = $addAccountRepository;
    $this->encrypter = $encrypter;
  }

  public function add(array $data): Account
  {
    $data['password'] = $this->encrypter->encrypt($data['password']);
    $account = $this->addAccountRepository->add($data);
    return $account;
  }
}
