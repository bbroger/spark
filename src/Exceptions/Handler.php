<?php

namespace App\Exceptions;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
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
            ->withRedirect($this->request->getUri());
    }

    public function handleServerError()
    {
        return $this->render('errors/500.twig', 500);
    }

    protected function respond(): ResponseInterface
    {
        $exception = $this->exception;

        if ($exception instanceof HttpNotFoundException) {
            return $this->handleNotFoundException();
        } else if ($exception instanceof ValidationException) {
            return $this->handleValidationException($exception);
        } else if (
            ENVIRONMENT == ENV_PRODUCTION
            || $exception instanceof HttpMethodNotAllowedException
        ) {
            return $this->handleServerError();
        }

        return parent::respond();
    }
}
