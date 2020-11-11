<?php

use App\Infra\Db\Eloquent\Account\AccountRepository;
use App\Infra\Db\Eloquent\Database;
use PHPUnit\Framework\TestCase;

class AccountRepositoryTest extends TestCase
{
  private Database $database;
  private AccountRepository $sut;

  public function setUp(): void
  {
    $this->sut = new AccountRepository();
    $this->database = new Database();
    $this->database->connect();
  }

  public function tearDown(): void
  {
    $this->database->disconnect();
  }

  public function test_should_return_an_account_on_suuccess()
  {
    $account = $this->sut->add([
      'name'     => 'any_name',
      'email'    => 'any_mail@mail.com',
      'password' => 'any_password',
    ]);

    $this->assertEquals($account->getName(), 'any_name');
    $this->assertEquals($account->getEmail(), 'any_mail@mail.com');
    $this->assertEquals($account->getPassword(), 'any_password');
  }
}
