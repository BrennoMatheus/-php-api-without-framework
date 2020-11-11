<?php

use App\Data\Protocols\AddAccountRepositoryInterface;
use App\Data\Protocols\EncrypterInterface;
use App\Data\UseCases\DbAddAccount;
use App\Domain\Models\Account;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DbAddAccountTest extends TestCase
{
  private DbAddAccount $sut;

  /** @var AddAccountRepositoryInterface|MockObject */
  private $addAccountRepositoryStub;

  /** @var EncrypterInterface|MockObject */
  private $encrypterInterfaceStub;

  private $data = [
    'name'     => 'any_name',
    'email'    => 'any_mail@mail.com',
    'password' => 'any_password',
  ];

  public function setUp(): void
  {
    /** @var AddAccountRepositoryInterface|MockObject */
    $this->addAccountRepositoryStub = $this->createMock(AddAccountRepositoryInterface::class);

    /** @var EncrypterInterface|MockObject */
    $this->encrypterInterfaceStub = $this->createMock(EncrypterInterface::class);

    $this->sut = new DbAddAccount($this->addAccountRepositoryStub, $this->encrypterInterfaceStub);
  }

  public function test_should_calls_encrypter_with_correct_password()
  {
    $this->encrypterInterfaceStub
      ->expects($this->once())
      ->method('encrypt')
      ->with($this->data['password']);

    $this->sut->add($this->data);
  }

  public function test_should_calls_add_account_repository_with_correct_values()
  {
    $this->encrypterInterfaceStub
      ->method('encrypt')
      ->willReturn('hashed_password');

    $this->addAccountRepositoryStub
      ->expects($this->once())
      ->method('add')
      ->with([
        'name'     => 'any_name',
        'email'    => 'any_mail@mail.com',
        'password' => 'hashed_password',
      ]);

    $this->sut->add($this->data);
  }

  public function test_should_throw_if_encrypter_throws()
  {
    $this->expectException('exception');

    $this->encrypterInterfaceStub
      ->method('encrypt')
      ->willThrowException(new \Exception('exception'));

    $this->sut->add($this->data);
  }

  public function test_should_throw_if_add_account_repository_throws()
  {
    $this->expectException('exception');

    $this->addAccountRepositoryStub
      ->method('add')
      ->willThrowException(new \Exception('exception'));

    $this->sut->add($this->data);
  }

  public function should_return_an_account_on_success()
  {
    $this->addAccountRepositoryStub
      ->method('add')
      ->willReturn(new Account($this->data));

    $account = $this->sut->add($this->data);

    $this->assertEquals($account, new Account($this->data));
  }
}
