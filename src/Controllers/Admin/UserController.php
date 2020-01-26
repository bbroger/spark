<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index($request, $response)
    {
        \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($request) {
            return $request->getParam('page', 1);
        });

        $query = $request->getParam('search', '');
        $users = User::paginate(15);

        return $this->render($response, 'admin/users/index.twig', [
            'users' => $users
        ]);
    }
}
