<?php

namespace App\Controllers;

use Slim\Http\Response;
use Slim\Views\Twig;

class HomeController
{
    public function index(Response $response, Twig $twig)
    {
        return $twig->render($response, 'welcome.twig');
    }
}
