<?php

use App\Controllers\HomeController;
use Slim\App;

return function ($app) {
    $app->get('/', HomeController::class . ':index');
};
