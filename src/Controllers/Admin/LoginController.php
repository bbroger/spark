<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class LoginController extends Controller
{
    public function index($request, $response)
    {
        return $this->render($response, 'admin/auth/login.twig');
    }
}