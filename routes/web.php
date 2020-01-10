<?php

/** @var \Slim\App $app */

$app->get('/', 'App\Controllers\HomeController:index');
$app->get('/user/', function ($req, $res) {
    $res->getBody()->write('Hello, world!');
    return $res;
});