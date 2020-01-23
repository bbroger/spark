<?php

namespace App\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UtilityExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('dump', 'dump', ['is_safe' => ['html']]),
            new TwigFunction('var_dump', 'var_dump'),
        ];
    }
}
