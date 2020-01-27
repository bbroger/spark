<?php

namespace App\Middlewares;

class FlashMiddleware
{
    private $flash;

    public function __construct($flash)
    {
        $this->flash = $flash;
    }

    public function __invoke($request, $handler)
    {
        $this->flash->setPreviuousUrl($request->getUri()->getPath());

        return $handler->handle($request);
    }
}
