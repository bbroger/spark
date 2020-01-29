<?php

use App\Auth\Manager;
use App\Exceptions\Handler;
use Slim\Views\Twig;
use Slim\Csrf\Guard;
use Slim\Factory\ServerRequestCreatorFactory;
use App\Session\Flash;
use Odan\Session\PhpSession;
use App\Validation\Validator;
use Illuminate\Database\Capsule\Manager as Capsule;

$container['app'] = $app;

$container['auth'] = function ($c) {
    return new Manager($c['session'], $c['request']);
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

    require_once PATH_CONFIG . '/view.php';

    return $view;
};

$container['errorHandler'] = function ($c) {
    return new Handler(
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

$container['db'] = function () {
    $capsule = new Capsule;
    $capsule->addConnection([
        'driver'    => env_get('DB_DRIVER', 'mysql'),
        'host'      => env_get('DB_HOST', 'localhost'),
        'database'  => env_get('DB_DATABASE', 'spark'),
        'username'  => env_get('DB_USERNAME', 'root'),
        'password'  => env_get('DB_PASSWORD', 'root'),
        'charset'   => env_get('DB_CHARSET', 'utf8'),
        'collation' => env_get('DB_COLLATION', 'utf8_unicode_ci'),
        'prefix'    => env_get('DB_PREFIX', ''),
    ]);

    return $capsule;
};

$container['viewFactory'] = function ($c) {
    return new Factory($c['view']);
};

$container['pageResolver'] = function ($c) {
    return $c['request']->getParam('page');
};
