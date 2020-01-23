<?php

namespace App\Middlewares;

class GuestMiddleware
{
    private $auth;
    private $responseFactory;

    public function __construct($auth, $responseFactory)
    {
        $this->auth = $auth;
        $this->responseFactory = $responseFactory;
    }

    public function __invoke($request, $handler)
    {
        if ($this->auth->check()) {
            return $this->responseFactory->createResponse()
                ->withRedirect('/admin');
        }

        return $handler->handle($request);
    }
}