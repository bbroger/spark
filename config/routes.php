<?php

use App\Controllers\ExampleController;
use App\Controllers\HomeController;
use App\Controllers\Admin\LoginController;

$app->get('/', HomeController::class . ':index');

$app->group('/admin', function ($group) {
    $group->get('/login', LoginController::class . ':index');
});

if (ENVIRONMENT === ENV_DEVELOPMENT) {
    $app->get('/test', function ($request, $response) {
        return $response->write(asset('/test.php'));
    });    

    $app->group('/example', function ($group) {
        $group->get('/', ExampleController::class . ':index');
        $group->post('/', ExampleController::class . ':store');
    });
}
