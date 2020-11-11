<?php

namespace App\Examples;

class HelloWorld
{
  public function handle($req)
  {
    $name = $req->getAttribute('name');
    return "Hello $name";
  }
}
