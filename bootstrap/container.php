<?php

use App\Data\Protocols\AddAccountRepositoryInterface;
use App\Data\Protocols\EncrypterInterface;
use App\Data\UseCases\DbAddAccount;
use App\Domain\UseCases\AddAccountInterface;
use App\Infra\Criptography\EncryptAdapter;
use App\Infra\Db\Eloquent\Account\AccountRepository;
use App\Presentation\Helpers\Validators\EmailValidatorAdapter;
use App\Presentation\Protocols\EmailValidatorInterface;
use DI\ContainerBuilder;

use function DI\autowire;

return (new ContainerBuilder())
  ->addDefinitions([
    AddAccountInterface::class            => autowire(DbAddAccount::class),
    EmailValidatorInterface::class        => autowire(EmailValidatorAdapter::class),
    EncrypterInterface::class             => autowire(EncryptAdapter::class),
    AddAccountRepositoryInterface::class  => autowire(AccountRepository::class),
  ])
  ->build();
