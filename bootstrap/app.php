<?php

use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;
use Middlewares\TrailingSlash;

$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->add(new MethodOverrideMiddleware());
$app->add(new TrailingSlash(true));

require __DIR__ . '/../routes/web.php';

return $app;