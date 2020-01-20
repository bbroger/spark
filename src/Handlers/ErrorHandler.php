<?php

namespace App\Handlers;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Handlers\ErrorHandler as BaseErrorHandler;

class ErrorHandler extends BaseErrorHandler
{
    private $view;

    public function __construct($callableResolver, $responseFactory, $view)
    {
        parent::__construct($callableResolver, $responseFactory);

        $this->view = $view;
    }

    public function render($view, $statusCode = 200)
    {
        $response = $this->responseFactory->createResponse($statusCode);

        return $this->view->render($response, $view);
    }

    protected function respond(): ResponseInterface
    {
        if ($this->exception instanceof HttpNotFoundException) {
            return $this->render('errors/404.twig', 404);
        } else if (ENVIRONMENT == ENV_PRODUCTION) {
            return $this->render('errors/500.twig', 500);
        }

        return parent::respond();
    }
}
