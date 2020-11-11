<?php

namespace App\Domain\Models;

class Account
{
  private ?int $id;
  private ?string $name;
  private ?string $email;
  private ?string $password;

  public function __construct(array $data)
  {
    $this->id = isset($data['id']) ? $data['id'] : null;
    $this->name = isset($data['name']) ? $data['name'] : null;
    $this->email = isset($data['email']) ? $data['email'] : null;
    $this->password = isset($data['password']) ? $data['password'] : null;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function toArray()
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'email' => $this->email,
    ];
  }
}
