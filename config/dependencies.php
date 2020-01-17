<?php

use Slim\Views\Twig;

return [
    Twig::class => function (): Twig {
        dd(env_get('TWIG_CACHE_ENABLED'));

        dd(((bool) env_get('TWIG_CACHE_ENABLED', true))
            ? ['cache' => PATH_CACHE]
            : []);

        return Twig::create(
            PATH_VIEWS,
            ((bool) env_get('TWIG_CACHE_ENABLED', true))
                ? ['cache' => PATH_CACHE]
                : []
        );
    }
];
