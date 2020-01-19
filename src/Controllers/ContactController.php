<?php

namespace App\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Respect\Validation\Validator as V;

class ContactController extends Controller
{
    /**
     * Show contact form.
     */
    public function index(ServerRequest $request, Response $response): Response
    {
        return $this->view->render($response, 'contact.twig');
    }

    /**
     * Store client message.
     */
    public function store(ServerRequest $request, Response $response): Response
    {
        $this->validator->validate($request, [
            'name' => V::notBlank()
        ]);

        return $this->index($request, $response);
    }
}
