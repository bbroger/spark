<?php

$view->addExtension(
    new App\Extensions\CsrfExtension($container['csrf'])
);

$view->addExtension(
    new Awurth\SlimValidation\ValidatorExtension(
        $container['validator']
    )
);

$view->addExtension(
    new App\Extensions\SessionExtension(
        $container['session'], $container['flash']
    )
);

$view->addExtension(
    new App\Extensions\ConfigExtension()
);

$view->addExtension(
    new App\Extensions\UtilityExtension()
);