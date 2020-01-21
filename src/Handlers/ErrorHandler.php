<?php

namespace App\Handlers;

use App\Exceptions\ValidationException;
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

    public function notFound()
    {
        return $this->render('errors/404.twig', 404);
    }

    public function validationException($code)
    {
        return $this->responseFactory->createResponse($code)
            ->withRedirect($this->request->getUri());
    }

    public function serverError()
    {
        return $this->render('errors/500.twig', 500);
    }

    protected function respond(): ResponseInterface
    {
        $exception = $this->exception;

        if ($exception instanceof HttpNotFoundException) {
            return $this->notFound();
        } else if ($exception instanceof ValidationException) {
            return $this->validationException($exception->getCode());
        } else if (ENVIRONMENT == ENV_PRODUCTION) {
            return $this->serverError();
        }

        return parent::respond();
    }
}
