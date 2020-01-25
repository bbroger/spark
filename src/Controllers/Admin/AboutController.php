<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class AboutController extends Controller
{
    public function index($request, $response)
    {
        return $this->render($response, 'admin/about.twig');
    }
}
