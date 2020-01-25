<?php

if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

/**
 * Folders
 */
define('FOLDER_CSS', '/css');
define('FOLDER_JS', '/js');
define('FOLDER_IMAGES', '/images');

/**
 * Paths.
 */
define('PATH_ROOT', dirname(__DIR__));
define('PATH_APP', PATH_ROOT . '/src');
define('PATH_RESOURCES', PATH_ROOT . '/resources');
define('PATH_DATABASE', PATH_ROOT . '/database');
define('PATH_WEBROOT', PATH_ROOT . '/public');
define('PATH_VENDOR', PATH_ROOT . '/vendor');
define('PATH_STORAGE', PATH_ROOT . '/storage');
define('PATH_CONFIG', PATH_ROOT . '/config');
define('PATH_VIEWS', PATH_RESOURCES . '/views');
define('PATH_CACHE', PATH_STORAGE . '/cache');
define('PATH_CSS', PATH_WEBROOT . FOLDER_CSS);
define('PATH_JS', PATH_WEBROOT . FOLDER_JS);
define('PATH_IMAGES', PATH_WEBROOT . FOLDER_IMAGES);

/**
 * Environment types.
 */
define('ENV_PRODUCTION', 'production');
define('ENV_DEVELOPMENT', 'development');
