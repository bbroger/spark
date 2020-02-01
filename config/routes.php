<?php

use App\Controllers\HomeController;
use App\Controllers\Admin\LoginController;
use App\Middlewares\AdminMiddleware;
use App\Controllers\Admin;
use App\Middlewares\GuestMiddleware;

/**
 * Public routes.
 */
$app->get('/', HomeController::class . ':index');

/**
 * Admin routes.
 */
$app->group('/admin', function ($group) {
    $responseFactory = $group->getResponseFactory();
    $auth = $group->getContainer()->get('auth');

    /**
     * Auth routes.
     */
    $group->group('', function ($group) {
        $group->get('/login', LoginController::class . ':index');
        $group->post('/login', LoginController::class . ':attempt');
    })->add(new GuestMiddleware($auth, $responseFactory));

    /**
     * Private routes.
     */
    $group->group('', function ($group) {
        $group->get('', Admin\HomeController::class . ':index');

        /**
         * Auth routes.
         */
        $group->get('/logout', LoginController::class . ':logout');

        /**
         * Static pages.
         */
        $group->get('/about', Admin\AboutController::class . ':index');

        /**
         * Settings.
         */
        $group->group('/settings', function ($group) {
            $group->get('', Admin\SettingController::class .  ':index');
            $group->post('', Admin\SettingController::class .  ':update');
        });

        /**
         * Users
         */
        $group->group('/users', function ($group) {
            $group->get('', Admin\UserController::class . ':index');
            $group->get('/create', Admin\UserController::class . ':create');
            $group->post('', Admin\UserController::class . ':store');

            $group->group('/{id:[0-9]+}', function ($group) {
                $group->put('', Admin\UserController::class .  ':update');
                $group->get('/edit', Admin\UserController::class .  ':edit');
                $group->delete('', Admin\UserController::class . ':delete');
            });
        });
    })->add(new AdminMiddleware($auth, $responseFactory));
});
