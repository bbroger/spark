<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Illuminate\Support\MessageBag;

class SessionExtension extends AbstractExtension
{
    private $session;
    private $flash;
    private $errorBag;

    public function __construct($session, $flash)
    {
        $this->session = $session;
        $this->flash = $flash;
        $this->errorBag = (new MessageBag())
            ->merge($flash->getErrors());
    }

    public function getGlobals()
    {
        return [
            'session' => $this->session,
            'flash' => $this->flash,
            'errors' => $this->errorBag
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('old', [$this, 'old']),
            new TwigFunction('error', [$this->errorBag, 'first'])
        ];
    }

    public function old($key, $default = null)
    {
        return $this->flash->old($key, $default);
    }
}