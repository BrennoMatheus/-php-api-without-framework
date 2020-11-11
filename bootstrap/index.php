<?php

declare(strict_types=1);

use App\Infra\Db\Eloquent\Database;
use Laminas\Diactoros\ServerRequestFactory;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$middlewares  = require_once dirname(__DIR__) . '/bootstrap/middlewares.php';

$requestHandler = new Relay($middlewares);

(new Database())->connect();

$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

return (new SapiEmitter())->emit($response);
