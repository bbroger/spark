<?php

use App\Twig\CsrfExtension;
use App\Twig\FormExtension;
use Slim\Views\Twig;
use Slim\Csrf\Guard;
use Slim\Factory\ServerRequestCreatorFactory;

return [
    'request' => function () {
        $serverRequestCreator = ServerRequestCreatorFactory::create();
        return $serverRequestCreator->createServerRequestFromGlobals();
    },

    'csrf' => function ($c) {
        return new Guard($c['app']->getResponseFactory());
    },

    'validator' => function () {
        return new Awurth\SlimValidation\Validator;
    },

    'view' => function ($c) {
        $settings = env_get('TWIG_CACHE_ENABLED', true)
            ? ['cache' => PATH_CACHE]
            : [];

        $view = Twig::create(PATH_VIEWS, $settings);

        $view->addExtension(new CsrfExtension($c['csrf']));
        $view->addExtension(
            new Awurth\SlimValidation\ValidatorExtension(
                $c['validator']
            )
        );
        $view->addExtension(new FormExtension($c['request']));

        return $view;
    },
];
