<?php

/** @var \Slim\App $app */

use App\Controllers\ContactController;
use App\Controllers\HomeController;
use Slim\Routing\RouteCollectorProxy;

$app->get('/', HomeController::class . ':index');

$app->group('/contact', function (RouteCollectorProxy $group) {
    $group->get('/', ContactController::class . ':index');
    $group->post('/', ContactController::class . ':store');
});
