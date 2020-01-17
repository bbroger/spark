<?php

require __DIR__ . '/../vendor/autoload.php';

/** @var \Slim\App $app */
$app = require PATH_BOOTSTRAP . '/app.php';

$app->run();
