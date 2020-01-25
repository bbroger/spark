<?php

namespace App\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Illuminate\Support\Str;

class UtilityExtension extends AbstractExtension
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('dump', 'dump', ['is_safe' => ['html']]),
            new TwigFunction('var_dump', 'var_dump'),
            new TwigFunction('is_active', [$this, 'isActive'])
        ];
    }

    public function isActive($route)
    {
        $path = $this->request->getUri()->getPath();

        if (Str::startsWith($path, '/admin')) {
            $route = '/admin' . $route;
        }

        return $path == $route ? 'active' : null;
    }
}
