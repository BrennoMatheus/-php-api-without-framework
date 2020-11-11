<?php

namespace App\Presentation\Helpers\Validators;

use App\Presentation\Protocols\EmailValidatorInterface;
use Valitron\Validator;

class EmailValidatorAdapter implements EmailValidatorInterface
{
  private Validator $validator;

  public function __construct(Validator $validator)
  {
    $this->validator = $validator;
  }

  public function isValid(string $email): bool
  {
    $this->validator = $this->validator->withData(['email' => $email]);
    $this->validator->rule('email', 'email');
    return $this->validator->validate();
  }
}
