<?php

use App\Controllers\ContactController;
use App\Controllers\HomeController;

return function ($app) {
    $app->get('/', HomeController::class . ':index');

    $app->group('/contact', function ($group) {
        $group->get('/', ContactController::class . ':index');
        $group->post('/', ContactController::class . ':store');
    });
};
