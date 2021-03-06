<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function index($request, $response)
    {
        return $this->render($response, 'admin/auth/login.twig');
    }

    public function attempt($request, $response)
    {
        $email = $request->getParam('email');
        $password = $request->getParam('password');

        $this->auth->attempt($email, $password, User::ADMIN);

        return $response->withRedirect('/admin');
    }

    public function logout($request, $response)
    {
        $this->auth->logout();

        return $response->withRedirect('/admin/login');
    }
}