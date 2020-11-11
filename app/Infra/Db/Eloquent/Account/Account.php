<?php

namespace App\Infra\Db\Eloquent\Account;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
  protected $table = 'accounts';
  protected $fillable = ['name', 'email', 'password'];
  public $timestamps = false;
}
