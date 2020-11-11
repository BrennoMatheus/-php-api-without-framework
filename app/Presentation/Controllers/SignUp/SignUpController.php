<?php

namespace App\Presentation\Controllers\SignUp;

use App\Domain\UseCases\AddAccountInterface;
use App\Presentation\Exceptions\InvalidParamException;
use App\Presentation\Exceptions\MissingParamException;
use App\Presentation\Http\HttpResponse;
use App\Presentation\Protocols\ControllerInterface;
use App\Presentation\Protocols\EmailValidatorInterface;
use App\Presentation\Protocols\HttpRequestInterface;
use App\Presentation\Protocols\HttpResponseInterface;
use Exception;

use function App\Presentation\Helpers\Http\badRequest;
use function App\Presentation\Helpers\Http\serverError;

class SignUpController implements ControllerInterface
{
  private EmailValidatorInterface $emailValidator;
  private AddAccountInterface $addAccount;

  public function __construct(EmailValidatorInterface $emailValidator, AddAccountInterface $addAccount)
  {
    $this->emailValidator = $emailValidator;
    $this->addAccount = $addAccount;
  }

  public function handle(HttpRequestInterface $request): HttpResponseInterface
  {
    try {
      $data = $request->all();

      $requiredFields = ['name', 'email', 'password', 'password_confirmation'];

      foreach ($requiredFields as $field)
        if (!isset($data[$field]))
          return badRequest(new MissingParamException($field));

      if ($data['password'] !== $data['password_confirmation'])
        return badRequest(new InvalidParamException('password_confirmation'));

      if (!$this->emailValidator->isValid($data['email']))
        return badRequest(new InvalidParamException('email'));

      $account = $this->addAccount->add($data);
      return new HttpResponse(200, $account->toArray());
    } catch (Exception $e) {
      return serverError();
    }
  }
}
