<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;
use Slim\Exception\HttpNotFoundException;

class UserController extends Controller
{
    public function index($request, $response)
    {
        $query = $request->getParam('search', '');
        $users = User::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('email', 'LIKE', '%' . $query . '%')
            ->paginate(15);

        return $this->render($response, 'admin/users/index.twig', [
            'users' => $users
        ]);
    }

    public function create($request, $response)
    {
        return $this->render($response, 'admin/users/form.twig', [
            'title' => 'Novo usuário'
        ]);
    }

    public function store($request, $response)
    {
        $user = $this->validate($request, [
            'name' => v::notBlank()->setName('nome'),
            'email' => v::notBlank()->uniqueField(User::class, 'email')->email(),
            'password' => v::notBlank()->length(6)->setName('senha'),
            'type' => v::notBlank()->in(['admin', 'normal'])->setName('tipo'),
            'avatar' => v::optional(v::uploaded()->image())
        ], [
            'password.length' => 'O campo senha precisa ter no mínimo 6 caracteres.'
        ]);

        if (isset($user['avatar'])) {
            $user['avatar'] = moveUploadedFile($user['avatar'], PATH_AVATARS);
        }

        $id = User::create($user)->id;

        return $response->withRedirect(admin_url("/users/{$id}/edit"));
    }

    public function edit($request, $response, $args)
    {
        $user = User::findOrFail($args['id']);

        return $this->render($response, 'admin/users/form.twig', [
            'title' => 'Editar um usuário',
            'user' => $user
        ]);
    }

    public function update($request, $response, $args)
    {
        $user = User::findOrFail($args['id']);

        $inputs = $this->validate($request, [
            'email' => v::optional(
                v::uniqueField(User::class, 'email', $user->email)->email()
            ),

            'password' => v::optional(
                v::length(6)
            )->setName('senha'),

            'type' => v::optional(
                v::in(['admin', 'normal'])
            )->setName('tipo'),

            'avatar' => v::optional(
                v::uploaded()->image()
            )
        ], [
            'password.length' => 'O campo senha precisa ter no mínimo 6 caracteres.'
        ]);

        if (isset($inputs['avatar'])) {
            $inputs['avatar'] = moveUploadedFile($inputs['avatar'], PATH_AVATARS);
        }

        $user->update($inputs);

        return $response->withRedirect(admin_url("/users/{$user->id}/edit"));
    }

    public function delete($request, $response, $args)
    {
        $user = User::findOrFail($args['id']);

        if ($user->id == $this->auth->user()->id) {
            return $response->withStatus(403);
        }

        $user->delete();

        return $response->write('User deleted with successfully.');
    }
}
