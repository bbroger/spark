<?php

namespace App\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ConfigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return $this->createFunctions([
            'asset',
            'asset_url',
            'asset_js',
            'asset_css',
            'url',
            'app_url',
            'app_name',
            'setting'
        ]);
    }

    public function createFunctions($functions)
    {
        foreach ($functions as $key => $name) {
            $functions[$key] = new TwigFunction($name, $name);
        }

        return $functions;
    }
}
