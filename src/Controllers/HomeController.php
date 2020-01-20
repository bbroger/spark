<?php

namespace App\Controllers;

class HomeController extends Controller
{
    /**
     * Show index page.
     */
    public function index($request, $response)
    {
        return $this->view->render($response, 'welcome.twig');
    }
}
