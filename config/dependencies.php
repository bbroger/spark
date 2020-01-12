<?php

use Slim\Views\Twig;

return [
    Twig::class => function () {
        return Twig::create(__DIR__ . '/../resources/views');
    }
];
