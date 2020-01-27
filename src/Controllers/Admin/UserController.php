<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;

class UserController extends Controller
{
    public function index($request, $response)
    {
        $query = $request->getParam('search', '');
        $users = User::where('name', 'LIKE', '%' . $query . '%')
            ->paginate(15);

        return $this->render($response, 'admin/users/index.twig', [
            'users' => $users
        ]);
    }

    public function create($request, $response)
    {
        return $this->render($response, 'admin/users/create.twig');
    }

    public function store($request, $response)
    {
        $user = $this->validate($request, [
            'name' => v::notBlank()->setName('nome'),
            'email' => v::notBlank()->uniqueField(User::class, 'email')->email(),
            'password' => v::notBlank()->length(6)->setName('senha'),
            'type' => v::notBlank()->in(['admin', 'normal'])->setName('tipo')
        ], [
            'password.length' => 'O campo senha precisa ter no mínimo 6 caracteres.'
        ]);

        $id = User::create($user)->id;

        return $response->withRedirect(admin_url("/users/{$id}/edit"));
    }
}
