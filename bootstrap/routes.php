<?php

use App\Examples\HelloWorldAdapter;
use App\Presentation\Controllers\SignUp\SignUpController;
use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;
use function App\Main\Adapters\adaptRoute;

function getDispacher($container)
{
  return $dispacher = simpleDispatcher(function (RouteCollector $r) use ($container) {
    $r->get('/hello/{name}', HelloWorldAdapter::class);

    $r->post('/add-accounts', adaptRoute($container->get(SignUpController::class)));
  });
}
