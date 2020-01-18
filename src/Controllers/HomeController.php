<?php

namespace App\Controllers;

use Slim\Http\Response;
use Slim\Http\Request;
use Slim\Views\Twig;

class HomeController extends Controller
{
    public function index(Request $request, Response $request)
    {
        return $this->view->render($response, 'welcome.twig');
    }
}