<?php

use App\Controllers\ExampleController;
use App\Controllers\HomeController;
use App\Controllers\Admin\LoginController;
use App\Middlewares\AdminMiddleware;
use App\Controllers\Admin;
use App\Middlewares\GuestMiddleware;

$app->get('/', HomeController::class . ':index');

$app->group('/admin', function ($group) {
    $responseFactory = $group->getResponseFactory();
    $auth = $group->getContainer()->get('auth');

    $group->group('', function ($group) {
        $group->get('/login', LoginController::class . ':index');
        $group->post('/login', LoginController::class . ':attempt');
    })->add(new GuestMiddleware($auth, $responseFactory));

    $group->group('', function ($group) {
        $group->get('', Admin\HomeController::class . ':index');
        $group->get('/about', Admin\AboutController::class . ':index');

        $group->group('/users', function ($group) {
            $group->get('', Admin\UserController::class . ':index');
            $group->get('/create', Admin\UserController::class . ':create');
            $group->post('', Admin\UserController::class . ':store');
        });

        // TODO: Replace HTTP get method with POST method.
        $group->get('/logout', LoginController::class . ':logout');
    })->add(new AdminMiddleware($auth, $responseFactory));
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
