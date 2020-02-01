<?php

if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

/**
 * Folders
 */
define('FOLDER_CSS', '/css');
define('FOLDER_JS', '/js');
define('FOLDER_IMAGES', '/images');
define('FOLDER_STORAGE', '/storage');
define('FOLDER_UPLOADED_IMAGES', '/storage/images');

/**
 * Paths.
 */
define('PATH_ROOT', dirname(__DIR__));
define('PATH_APP', PATH_ROOT . '/src');
define('PATH_RESOURCES', PATH_ROOT . '/resources');
define('PATH_DATABASE', PATH_ROOT . '/database');
define('PATH_WEBROOT', PATH_ROOT . '/public');
define('PATH_VENDOR', PATH_ROOT . '/vendor');
define('PATH_CONFIG', PATH_ROOT . '/config');
define('PATH_VIEWS', PATH_RESOURCES . '/views');
define('PATH_TMP', PATH_ROOT . '/tmp');
define('PATH_CACHE', PATH_TMP . '/cache');
define('PATH_CSS', PATH_WEBROOT . FOLDER_CSS);
define('PATH_JS', PATH_WEBROOT . FOLDER_JS);
define('PATH_IMAGES', PATH_WEBROOT . FOLDER_IMAGES);
define('PATH_STORAGE', PATH_WEBROOT . '/storage');
define('PATH_UPLOADED_IMAGES', PATH_WEBROOT . FOLDER_UPLOADED_IMAGES);
define('PATH_FILES', PATH_STORAGE . '/files');

/**
 * Environment types.
 */
define('ENV_PRODUCTION', 'production');
define('ENV_DEVELOPMENT', 'development');
