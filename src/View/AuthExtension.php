<?php

namespace App\View;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

class AuthExtension extends AbstractExtension implements GlobalsInterface
{
    private $auth;

    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    public function getGlobals(): array
    {
        return [
            'auth' => $this->auth,
            'currentUser' => $this->auth->user()
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('user', [$this->auth, 'user'])
        ];
    }
}
