<?php

namespace App\Examples;

class HelloWorldAdapterFactory
{
  public function create()
  {
    return new HelloWorldAdapter(new HelloWorld());
  }
}
