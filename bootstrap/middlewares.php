<?php

use App\Main\Middlewares\JsonParsedBody;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;

require_once dirname(__DIR__) . '/bootstrap/routes.php';

$container = require_once dirname(__DIR__) . '/bootstrap/container.php';

$routes = getDispacher($container);

return [
  new FastRoute($routes),
  new JsonParsedBody(),
  new RequestHandler($container),
];
