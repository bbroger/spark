<?php

use App\Controllers\ContactController;
use App\Controllers\HomeController;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;

return function (App $app) {
    $app->get('/', HomeController::class . ':index');

    $app->group('/contact', function (RouteCollectorProxy $group) {
        $group->get('/', ContactController::class . ':index');
        $group->post('/', ContactController::class . ':store');
    });
};
