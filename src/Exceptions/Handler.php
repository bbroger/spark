<?php

namespace App\Exceptions;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\{
    HttpMethodNotAllowedException,
    HttpForbiddenException,
    HttpNotFoundException
};
use Slim\Handlers\ErrorHandler;

class Handler extends ErrorHandler
{
    private $view;
    private $flash;

    public function __construct(
        $callableResolver,
        $responseFactory,
        $view,
        $flash
    ) {
        parent::__construct($callableResolver, $responseFactory);

        $this->view = $view;
        $this->flash = $flash;
    }

    public function render($view, $statusCode = 200)
    {
        $response = $this->responseFactory->createResponse($statusCode);

        return $this->view->render($response, $view);
    }

    public function handleNotFoundException()
    {
        return $this->render('errors/404.twig', 404);
    }

    public function handleValidationException($exception)
    {
        $this->flash->setErrors($exception->getErrors())
            ->setInputs($exception->getInputs());

        return $this->responseFactory->createResponse($exception->getCode())
            ->withRedirect($this->flash->getPreviousUrl());
    }

    public function handleServerError()
    {
        return $this->render('errors/500.twig', 500);
    }

    public function handleForbiddenException()
    {
        return $this->render('errors/403.twig', 403);
    }

    protected function respond(): ResponseInterface
    {
        $exception = $this->exception;

        if ($exception instanceof HttpNotFoundException) {
            return $this->handleNotFoundException();
        } else if ($exception instanceof ValidationException) {
            return $this->handleValidationException($exception);
        } else if ($exception instanceof HttpForbiddenException) {
            return $this->handleForbiddenException();
        } else if (ENVIRONMENT == ENV_PRODUCTION) {
            return $this->handleServerError();
        }

        return parent::respond();
    }
}
