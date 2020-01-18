<?php

session_start();

use Slim\Middleware\MethodOverrideMiddleware;
use Middlewares\TrailingSlash;
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;
use Slim\Views\TwigMiddleware;
use Slim\Views\Twig;
use Slim\Csrf\Guard;
use Pimple\Psr11\Container;

Dotenv::createImmutable(PATH_ROOT)->load();

$container = new Container();

$app = Bridge::create($container);
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->add(new MethodOverrideMiddleware())
    ->add(new TrailingSlash(true))
    ->add(TwigMiddleware::createFromContainer($app, Twig::class))
    ->add($container->get(Guard::class));

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

$capsule->setAsGlobal();
$capsule->bootEloquent();

require PATH_ROUTES . '/web.php';

return $app;
