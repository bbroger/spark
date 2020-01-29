<?php

$app->addRoutingMiddleware();
$app->add(new Slim\Middleware\MethodOverrideMiddleware())
    ->add(new Middlewares\TrailingSlash(false))
    ->add($container['csrf'])
    ->add(Slim\Views\TwigMiddleware::createFromContainer($app))
    ->add(new App\Middlewares\FlashMiddleware($container['flash']));

$errorMiddleware = $app->addErrorMiddleware(
    ENVIRONMENT == ENV_DEVELOPMENT,
    true,
    true
);

$errorMiddleware->setDefaultErrorHandler($container['errorHandler']);
