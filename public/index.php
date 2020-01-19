<?php

require __DIR__ . '/../vendor/autoload.php';

/** @var \Slim\App $app */
$app = require PATH_CONFIG . '/bootstrap.php';

$app->run(
    $app->getContainer()->get('request')
);
