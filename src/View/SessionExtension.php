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
            new TwigFunction('is_invalid', [$this, 'isInvalid']),
            new TwigFunction('error', [$this->errorBag, 'first']),
            new TwigFunction('is_selected', [$this, 'isSelected'])
        ];
    }

    public function isSelected($input, $item, $default = null)
    {
        return $this->flash->old($input) == $item
            || $default == $item ? ' selected' : null;
    }

    public function isInvalid($input)
    {
        return $this->errorBag->has($input) ? ' is-invalid' : '';
    }

    public function old($key, $default = null)
    {
        return $this->flash->old($key, $default);
    }
}
