<?php

namespace App\View;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Illuminate\Support\Str;
use Twig\Extension\GlobalsInterface;

class UtilityExtension extends AbstractExtension implements GlobalsInterface
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function getGlobals(): array
    {
        return [
            'request' => $this->request
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('dump', 'dump', ['is_safe' => ['html']]),
            new TwigFunction('var_dump', 'var_dump'),
            new TwigFunction('is_active', [$this, 'isActive']),
            new TwigFunction('is_menu_open', [$this, 'isMenuOpen']),
            new TwigFunction('is_string', 'is_string'),
            new TwigFunction('is_array', 'is_array'),
            new TwigFunction('method', [$this, 'method'], ['is_safe' => ['html']])
        ];
    }

    public function method($method)
    {
        return "<input type=\"hidden\" name=\"_METHOD\" value=\"$method\">";
    }

    public function isActive($route)
    {
        $path = rtrim($this->request->getUri()->getPath(), '/');

        if (Str::startsWith($path, '/admin')) {
            $route = '/admin' . $route;
        }

        return $path == $route ? 'active' : null;
    }

    public function isMenuOpen($route)
    {
        $path = $this->request->getUri()->getPath();

        if (Str::startsWith($path, '/admin')) {
            $route = '/admin' . $route;
        }

        return Str::startsWith($path, $route) ? 'menu-open menu-opened' : null;
    }
}
