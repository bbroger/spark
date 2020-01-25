<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;

class HomeController extends Controller
{
    public function index($request, $response)
    {
        $usersCount = User::count();

        return $this->render(
            $response,
            'admin/home.twig',
            compact('usersCount')
        );
    }
}
