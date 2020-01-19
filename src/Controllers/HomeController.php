<?php

namespace App\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class HomeController extends Controller
{
    /**
     * Show index page.
     */
    public function index(ServerRequest $request, Response $response): Response
    {
        return $this->view->render($response, 'welcome.twig');
    }
}
