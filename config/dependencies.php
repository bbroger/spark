<?php

use Slim\Views\Twig;

return [
    Twig::class => function (): Twig {
        return Twig::create(
            PATH_VIEWS,
            env_get('TWIG_CACHE_ENABLED', true)
                ? ['cache' => PATH_CACHE]
                : []
        );
    }
];
