<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class HomeController
{
    public function index(Request $request, Response $response): Response
    {
        $response->getBody()->write('Olá, mundo!');

        return $response;
    }
}
