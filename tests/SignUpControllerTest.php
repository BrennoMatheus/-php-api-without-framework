<?php

use App\Domain\Models\Account;
use App\Domain\UseCases\AddAccountInterface;
use App\Presentation\Controllers\SignUp\SignUpController;
use App\Presentation\Exceptions\InvalidParamException;
use App\Presentation\Exceptions\MissingParamException;
use App\Presentation\Exceptions\ServerException;
use App\Presentation\Http\HttpRequest;
use App\Presentation\Protocols\EmailValidatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SignUpControllerTest extends TestCase
{
  private SignUpController $sut;

  /** @var EmailValidatorInterface|MockObject */
  private $emailValidatorStub;

  /** @var AddAccountInterface|MockObject */
  private $addAccountStub;

  public function setUp(): void
  {
    /** @var EmailValidatorInterface|MockObject */
    $this->emailValidatorStub = $this->createMock(EmailValidatorInterface::class);

    /** @var AddAccountInterface|MockObject */
    $this->addAccountStub = $this->createMock(AddAccountInterface::class);

    $this->sut = new SignUpController($this->emailValidatorStub, $this->addAccountStub);
  }
  private function makeData(array $fields)
  {
    return [
      'id' => 1,
      'name' => array_key_exists('name', $fields) ? $fields['name'] : 'any_name',
      'email' => array_key_exists('email', $fields) ? $fields['email'] : 'any_mail@mail.com',
      'password' => array_key_exists('password', $fields) ? $fields['password'] : 'any_password',
      'password_confirmation' => array_key_exists('password_confirmation', $fields) ? $fields['password_confirmation'] : 'any_password',
    ];
  }

  public function test_should_return_400_if_no_name_has_provided()
  {;
    $data = $this->makeData(['name' => null]);

    $response = $this->sut->handle(new HttpRequest($data));

    $this->assertEquals($response->getStatusCode(), 400);
    $this->assertEquals($response->getBody(), new MissingParamException('name'));
  }

  public function test_should_return_400_if_no_email_has_provided()
  {
    $data = $this->makeData(['email' => null]);

    $response = $this->sut->handle(new HttpRequest($data));

    $this->assertEquals($response->getStatusCode(), 400);
    $this->assertEquals($response->getBody(), new MissingParamException('email'));
  }

  public function test_should_return_400_if_no_password_has_provided()
  {
    $data = $this->makeData(['password' => null]);

    $response = $this->sut->handle(new HttpRequest($data));

    $this->assertEquals($response->getStatusCode(), 400);
    $this->assertEquals($response->getBody(), new MissingParamException('password'));
  }

  public function test_should_return_400_if_no_password_confirmation_has_provided()
  {
    $data = $this->makeData(['password_confirmation' => null]);

    $response = $this->sut->handle(new HttpRequest($data));

    $this->assertEquals($response->getStatusCode(), 400);
    $this->assertEquals($response->getBody(), new MissingParamException('password_confirmation'));
  }

  public function test_should_return_400_if_an_invalid_password_confirmation_is_provided()
  {
    $data = $this->makeData(['password_confirmation' => 'invalid_password_confirmation']);

    $response = $this->sut->handle(new HttpRequest($data));

    $this->assertEquals($response->getStatusCode(), 400);
    $this->assertEquals($response->getBody(), new InvalidParamException('password_confirmation'));
  }

  public function test_should_call_email_validator_with_correct_email()
  {

    $data = $this->makeData([]);

    $this->emailValidatorStub
      ->expects($this->once())
      ->method('isValid')
      ->with($data['email']);

    $this->sut->handle(new HttpRequest($data));
  }

  public function test_should_return_400_if_an_invalid_email_is_provided()
  {
    $data = $this->makeData([]);

    $this->emailValidatorStub
      ->method('isValid')
      ->willReturn(false);

    $response = $this->sut->handle(new HttpRequest($data));

    $this->assertEquals($response->getStatusCode(), 400);
    $this->assertEquals($response->getBody(), new InvalidParamException('email'));
  }

  public function test_should_return_500_if_email_validator_throws()
  {
    $data = $this->makeData([]);

    $this->emailValidatorStub
      ->method('isValid')
      ->willThrowException(new ServerException());

    $response = $this->sut->handle(new HttpRequest($data));

    $this->assertEquals($response->getStatusCode(), 500);
    $this->assertEquals($response->getBody(), new ServerException());
  }

  public function test_should_call_add_account_with_correct_values()
  {
    $data = $this->makeData([]);

    $this->emailValidatorStub
      ->method('isValid')
      ->willReturn(true);

    $this->addAccountStub
      ->expects($this->once())
      ->method('add')
      ->with($data);

    $this->sut->handle(new HttpRequest($data));
  }

  public function test_should_return_500_if_add_account_throws()
  {
    $data = $this->makeData([]);

    $this->emailValidatorStub
      ->method('isValid')
      ->willReturn(true);

    $this->addAccountStub
      ->method('add')
      ->willThrowException(new ServerException());

    $response = $this->sut->handle(new HttpRequest($data));

    $this->assertEquals($response->getStatusCode(), 500);
    $this->assertEquals($response->getBody(), new ServerException());
  }

  public function test_should_returns_200_if_valid_data_is_provided()
  {
    $data = $this->makeData([]);

    $this->emailValidatorStub
      ->method('isValid')
      ->willReturn(true);

    $this->addAccountStub
      ->method('add')
      ->willReturn(new Account($data));

    $response = $this->sut->handle(new HttpRequest($data));

    $this->assertEquals($response->getStatusCode(), 200);
    $this->assertEquals($response->getBody(), new Account($data));
  }
}
