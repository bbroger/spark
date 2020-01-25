<?php

namespace App\Middlewares;

use App\Models\User;

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
        if (!$this->auth->check() || $this->auth->user()->type != User::ADMIN) {
            return $this->responseFactory->createResponse(403)
                ->withRedirect('/admin/login');
        }

        return $handler->handle($request);
    }
}
