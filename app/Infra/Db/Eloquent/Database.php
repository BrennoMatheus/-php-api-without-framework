<?php

namespace App\Infra\Db\Eloquent;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
  private Capsule $capsule;

  function __construct()
  {
    $this->capsule = new Capsule;
  }

  public function connect(): void
  {
    $this->capsule->addConnection([
      'driver' => 'mysql',
      'host' => 'localhost',
      'database' => 'php_without_a_framework',
      'username' => 'brenno',
      'password' => 'brenno',
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => '',
    ]);

    $this->capsule->bootEloquent();
  }

  public function disconnect(): void
  {
    $this->capsule->getConnection('default')->disconnect();
  }
}
