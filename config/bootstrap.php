<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;
use Pimple\Container;
use Pimple\Psr11\Container as Psr11Container;
use Slim\Factory\AppFactory;

/**
 * Load the environment variables.
 */
Dotenv::createImmutable(PATH_ROOT)->load();

/**
 * Load the app environment.
 */
define('ENVIRONMENT', env_get('APP_ENVIRONMENT'));

/**
 * Create the DI container.
 */
$container = new Container();

/**
 * Create the app.
 */
AppFactory::setContainer(new Psr11Container($container));
$app = AppFactory::create();

/**
 * Load container dependencies.
 */
require PATH_CONFIG . '/services.php';

/**
 * Load the session.
 */
$container['session']->start();

/**
 * Boot the Eloquent ORM.
 */
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

/**
 * Register app middlewares.
 */
require PATH_CONFIG . '/middlewares.php';

/**
 * Add error handling.
 */
$errorMiddleware = $app->addErrorMiddleware(
    ENVIRONMENT == ENV_DEVELOPMENT,
    true,
    true
);

$errorMiddleware->setDefaultErrorHandler($container['errorHandler']);

/**
 * Register the routes.
 */
require PATH_CONFIG . '/routes.php';

/**
 * Return app to front controller.
 */
return $app;
