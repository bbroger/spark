<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class HomeController extends Controller 
{
    public function index($request, $response)
    {
        return $this->render($response, 'admin/home.twig');
    }
}