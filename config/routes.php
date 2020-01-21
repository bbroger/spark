<?php

use App\Controllers\ExampleController;
use App\Controllers\HomeController;

return function ($app) {
    $app->get('/', HomeController::class . ':index');

    if (ENVIRONMENT === ENV_DEVELOPMENT) {
        $app->group('/example', function ($group) {
            $group->get('/', ExampleController::class . ':index');
            $group->post('/', ExampleController::class . ':store');
        });
    }
};
