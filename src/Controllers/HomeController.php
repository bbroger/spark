<?php

namespace App\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class HomeController extends Controller
{
    public function index(ServerRequest $request, Response $response)
    {
        return $this->view->render($response, 'welcome.twig');
    }
}
