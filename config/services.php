<?php

use App\Auth\Manager;
use Slim\Views\Twig;
use Slim\Csrf\Guard;
use Slim\Factory\ServerRequestCreatorFactory;
use App\Handlers\ErrorHandler;
use App\Session\Flash;
use Odan\Session\PhpSession;
use App\Validation\Validator;

$container['app'] = $app;

$container['auth'] = function ($c) {
    return new Manager($c['session']);
};

$container['request'] = function () {
    $serverRequestCreator = ServerRequestCreatorFactory::create();
    return $serverRequestCreator->createServerRequestFromGlobals();
};

$container['csrf'] = function ($c) {
    return new Guard($c['app']->getResponseFactory());
};

$container['validator'] = function () {
    $config = require_once PATH_CONFIG . '/validation.php';

    return new Validator(
        $config['showValidationRules'],
        $config['messages'],
        $config['attributes']
    );
};

$container['view'] = function ($container) {
    $settings = env_get('TWIG_CACHE_ENABLED', true)
        ? ['cache' => PATH_CACHE]
        : [];

    $view = Twig::create(PATH_VIEWS, $settings);

    require_once PATH_CONFIG . '/twig.php';

    return $view;
};

$container['errorHandler'] = function ($c) {
    return new ErrorHandler(
        $c['app']->getCallableResolver(),
        $c['app']->getResponseFactory(),
        $c['view'],
        $c['flash']
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
    return new Flash;
};