<?php

use App\Twig\CsrfExtension;
use App\Twig\FormExtension;
use Slim\Views\Twig;
use Slim\Csrf\Guard;
use Slim\Factory\ServerRequestCreatorFactory;
use App\Handlers\ErrorHandler;
use App\Twig\SessionExtension;
use Odan\Session\PhpSession;
use Slim\Flash\Messages;

return function ($container, $app) {
    $container['app'] = $app;

    $container['request'] = function () {
        $serverRequestCreator = ServerRequestCreatorFactory::create();
        return $serverRequestCreator->createServerRequestFromGlobals();
    };

    $container['csrf'] = function ($c) {
        return new Guard($c['app']->getResponseFactory());
    };

    $container['validator'] = function () {
        return new Awurth\SlimValidation\Validator;
    };

    $container['view'] = function ($c) {
        $settings = env_get('TWIG_CACHE_ENABLED', true)
            ? ['cache' => PATH_CACHE]
            : [];

        $view = Twig::create(PATH_VIEWS, $settings);

        $view->addExtension(new CsrfExtension($c['csrf']));
        $view->addExtension(new Awurth\SlimValidation\ValidatorExtension(
            $c['validator']
        ));
        $view->addExtension(new FormExtension($c['request']));
        $view->addExtension(new SessionExtension($c['session'], $c['flash']));

        return $view;
    };

    $container['errorHandler'] = function ($c) {
        return new ErrorHandler(
            $c['app']->getCallableResolver(),
            $c['app']->getResponseFactory(),
            $c['view']
        );
    };

    $container['session'] = function () {
        $session = new PhpSession();

        $session->setName(env_get('SESSION_NAME'));

        $session->setCookieParams(
            env_get('SESSION_COOKIE_LIFETIME'),
            env_get('SESSION_COOKIE_PATH'),
            env_get('SESSION_COOKIE_DOMAIN'),
            env_get('SESSION_COOKIE_SECURE'),
            env_get('SESSION_COOKIE_HTTPONLY')
        );

        return $session;
    };

    $container['flash'] = function () {
        return new Messages;
    };
};