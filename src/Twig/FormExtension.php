<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FormExtension extends AbstractExtension
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('old', [$this, 'getOldInput']),
        ];
    }

    public function getOldInput($name)
    {
        return $this->request->getParam($name);
    }
}
