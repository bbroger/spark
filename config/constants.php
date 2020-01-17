<?php

define('DS', DIRECTORY_SEPARATOR);

/**
 * Paths.
 */
define('PATH_ROOT', dirname(__DIR__));
define('PATH_APP', PATH_ROOT . '/src');
define('PATH_RESOURCES', PATH_ROOT . '/resources');
define('PATH_DATABASE', PATH_ROOT . '/database');
define('PATH_WEBROOT', PATH_ROOT . '/public');
define('PATH_ROUTES', PATH_ROOT . '/routes');
define('PATH_VENDOR', PATH_ROOT . '/vendor');
define('PATH_STORAGE', PATH_ROOT . '/storage');
define('PATH_CONFIG', PATH_ROOT . '/config');
define('PATH_BOOTSTRAP', PATH_ROOT . '/bootstrap');
define('PATH_VIEWS', PATH_RESOURCES . '/views');
define('PATH_CACHE', PATH_STORAGE . '/cache');

/**
 * Environment types.
 */
define('ENV_PRODUCTION', 'production');
define('ENV_DEVELOPMENT', 'development');
