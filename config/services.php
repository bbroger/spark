<?php

use Slim\Views\Twig;
use Slim\Csrf\Guard;

return [
    'view' => function () {
        return Twig::create(
            PATH_VIEWS,
            env_get('TWIG_CACHE_ENABLED', true)
                ? ['cache' => PATH_CACHE]
                : []
        );
    },

    'csrf' => function ($c) {
        return new Guard($c['app']->getResponseFactory());
    }
];
