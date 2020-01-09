<?php

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addErrorMiddleware(true, true, true);
$app->addRoutingMiddleware();

require __DIR__ . '/../routes/web.php';

return $app;