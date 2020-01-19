<?php

use Slim\Middleware\MethodOverrideMiddleware;
use Middlewares\TrailingSlash;
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;
use Slim\Views\TwigMiddleware;
use Pimple\Container;
use Pimple\Psr11\Container as Psr11Container;
use Slim\Factory\AppFactory;

session_start();

/**
 * Load the environment variables.
 */
Dotenv::createImmutable(PATH_ROOT)->load();

/**
 * Create the DI container.
 */
$container = new Container(require PATH_CONFIG . '/services.php');

/**
 * Create the app.
 */
AppFactory::setContainer(new Psr11Container($container));
$app = AppFactory::create();

/**
 * Register the app on container.
 */
$container['app'] = $app;

/**
 * Register app middlewares.
 */
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->add(new MethodOverrideMiddleware())
    ->add(new TrailingSlash(true))
    ->add(TwigMiddleware::createFromContainer($app))
    ->add($container['csrf']);

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
 * Register the routes.
 */ (require PATH_CONFIG . '/routes.php')($app);

/**
 * Return app to front controller.
 */
return $app;
