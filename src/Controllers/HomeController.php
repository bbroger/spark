<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController
{
    public function index(Request $request, Response $response): Response
    {
        echo 'eae';
        sleep(5);

        $response->getBody()->write('Olá, mundo!');

        return $response;
    }
}