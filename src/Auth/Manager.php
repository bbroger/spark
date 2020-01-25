<?php

namespace App\Auth;

use App\Models\User;
use App\Exceptions\ValidationException;

class Manager
{
    private $session;
    private $user;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function user()
    {
        if (is_null($this->user) && $this->check()) {
            $this->user = User::find($this->session->get('user_id'));
        }

        return $this->user;
    }

    public function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new ValidationException([
                'email' => ['E-mail não encontrado.'],
            ], compact('email', 'password'));
        }

        if (!password_verify($password, $user->password)) {
            throw new ValidationException([
                'password' => ['Senha inválida.']
            ], compact('email', 'password'));
        }

        $this->session->set('user_id', $user->id);

        $this->user = $user;

        return true;
    }

    public function check()
    {
        return $this->session->has('user_id');
    }

    public function logout()
    {
        $this->session->remove('user_id');
    }
}
