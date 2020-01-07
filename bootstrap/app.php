<?php

use Slim\Factory\AppFactory;

$app = AppFactory::create();

require __DIR__ . '/dependencies.php';
require __DIR__ . '/middlewares.php';
require __DIR__ . '/routes.php';

return $app;