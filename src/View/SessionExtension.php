<?php

namespace App\View;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Illuminate\Support\MessageBag;
use Twig\Extension\GlobalsInterface;

class SessionExtension extends AbstractExtension implements GlobalsInterface
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

    public function getGlobals(): array
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
