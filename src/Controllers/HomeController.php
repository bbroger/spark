<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController
{
    public function index(Request $request, Response $response): Response
    {
        throw new Exception('kk');

        $response->getBody()->write('Olá, mundo!');

        return $response;
    }
}
