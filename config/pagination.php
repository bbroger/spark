<?php

use Illuminate\Pagination\Paginator;
use App\View\Factory;

Paginator::viewFactoryResolver(function () use ($container) {
    return new Factory($container['view']);
});

Paginator::currentPageResolver(function ($pageName) use ($container) {
    return $container['request']->getParam($pageName, 1);
});

Paginator::currentPathResolver(function () use ($container) {
    return '?' . $container['request']->getUri()->getQuery();
});
