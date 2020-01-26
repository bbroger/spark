<?php

$view->addExtension(
    new App\View\CsrfExtension($container['csrf'])
);

$view->addExtension(
    new Awurth\SlimValidation\ValidatorExtension(
        $container['validator']
    )
);

$view->addExtension(
    new App\View\SessionExtension(
        $container['session'],
        $container['flash']
    )
);

$view->addExtension(
    new App\View\ConfigExtension()
);

$view->addExtension(
    new App\View\UtilityExtension($container['request'])
);

$view->addExtension(
    new App\View\AuthExtension($container['auth'])
);
