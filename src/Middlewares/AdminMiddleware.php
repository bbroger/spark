<?php

namespace App\Middlewares;

class AdminMiddleware
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
        if (! $this->auth->check()) {
            return $this->responseFactory->createResponse(403)
                ->withRedirect('/admin/login');
        }

        return $handler->handle($request);
    }
}