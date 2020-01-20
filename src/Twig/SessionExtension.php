<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;

class SessionExtension extends AbstractExtension
{
    private $session;
    private $flash;

    public function __construct($session, $flash)
    {
        $this->session = $session;
        $this->flash = $flash;
    }

    public function getGlobals()
    {
        return [
            'session' => $this->session,
            'flash' => $this->flash
        ];
    }
}