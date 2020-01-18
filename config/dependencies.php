<?php

use Slim\Views\Twig;
use Slim\Csrf\Guard;
use Slim\App;

return [
    Twig::class => function () {
        return Twig::create(
            PATH_VIEWS,
            env_get('TWIG_CACHE_ENABLED', true)
                ? ['cache' => PATH_CACHE]
                : []
        );
    },

    Guard::class => function (App $app) {
        return new Guard($app->getResponseFactory());
    }
];
