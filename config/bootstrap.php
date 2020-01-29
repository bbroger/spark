<?php

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
 * Boot the Eloquent ORM.
 */
$capsule = $container['db'];

$capsule->setAsGlobal();
$capsule->bootEloquent();

/**
 * Load the session.
 */
$container['session']->start();

/**
 * Configure the Illuminate\Pagination package.
 */
require __DIR__ . '/pagination.php';

/**
 * Register app middlewares.
 */
require PATH_CONFIG . '/middlewares.php';

/**
 * Register the routes.
 */
require PATH_CONFIG . '/routes.php';

/**
 * Return app to front controller.
 */
return $app;
