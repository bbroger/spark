<?php

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Slim\Middleware\MethodOverrideMiddleware;
use Middlewares\TrailingSlash;
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;
use Slim\Views\TwigMiddleware;
use Slim\Views\Twig;

Dotenv::createImmutable(PATH_ROOT)->load();

$builder = (new ContainerBuilder())
    ->addDefinitions(PATH_CONFIG . '/dependencies.php');

$app = Bridge::create($builder->build());
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->add(new MethodOverrideMiddleware())
    ->add(new TrailingSlash(true))
    ->add(TwigMiddleware::createFromContainer($app, Twig::class));

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
