<?php

namespace App\View;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AuthExtension extends AbstractExtension implements GlobalsInterface
{
    private $auth;
    private $user;

    public function __construct($auth)
    {
        $this->auth = $auth;
        $this->user = $auth->user();
    }

    public function getGlobals(): array
    {
        return [
            'auth' => $this->auth,
            'user' => $this->user
        ];
    }
}
