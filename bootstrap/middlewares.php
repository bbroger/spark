<?php

$app->addRoutingMiddleware();

// Remove this on production
$app->addErrorMiddleware(true, true, true);