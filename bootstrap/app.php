<?php

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Slim\Middleware\MethodOverrideMiddleware;
use Middlewares\TrailingSlash;
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;
use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;

Dotenv::createImmutable(__DIR__ . '/..')->load();

define('ENVIRONMENT', env_get('APP_ENVIRONMENT', 'production'));

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../config/dependencies.php');
$container = $builder->build();

$app = Bridge::create($container);

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->add(new MethodOverrideMiddleware());
$app->add(new TrailingSlash(true));

if (ENVIRONMENT === ENV_DEVELOPMENT) {
    $app->add(new WhoopsMiddleware());
} else {
    $app->add(false, true, true);
}

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

require __DIR__ . '/../routes/web.php';

return $app;
