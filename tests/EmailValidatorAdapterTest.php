<?php

use App\Presentation\Helpers\Validators\EmailValidatorAdapter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Valitron\Validator;

class EmailValidatorAdapterTest extends TestCase
{
  private EmailValidatorAdapter $sut;

  /** @var Validator|MockObject */
  private $validatorStub;

  public function setUp(): void
  {
    /** @var Validator|MockObject */
    $this->validatorStub = $this->createMock(Validator::class);

    $this->sut = new EmailValidatorAdapter($this->validatorStub);
  }

  public function test_should_return_false_if_validator_returns_false()
  {
    $this->validatorStub
      ->method('validate')
      ->willReturn(false);

    $this->assertFalse($this->sut->isValid('invalid_email'));
  }

  public function test_should_return_true_if_validator_returns_true()
  {
    $this->validatorStub
      ->method('validate')
      ->willReturn(true);

    $this->assertTrue($this->sut->isValid('mail@mail.com'));
  }

  public function test_should_set_correct_rule_with_correct_value()
  {
    $this->validatorStub
      ->expects($this->once())
      ->method('withData')
      ->with(['email' => 'mail@mail.com']);

    $this->validatorStub
      ->expects($this->once())
      ->method('rule')
      ->with('email', 'mail@mail.com');

    $this->validatorStub
      ->method('validate')
      ->willReturn(true);

    $this->sut->isValid('mail@mail.com');
  }
}
