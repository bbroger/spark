<?php

namespace App\View;

use Slim\Csrf\Guard;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

class CsrfExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var Guard
     */
    protected $csrf;

    public function __construct(Guard $csrf)
    {
        $this->csrf = $csrf;
    }

    public function getGlobals(): array
    {
        $csrfNameKey = $this->csrf->getTokenNameKey();
        $csrfValueKey = $this->csrf->getTokenValueKey();
        $csrfName = $this->csrf->getTokenName();
        $csrfValue = $this->csrf->getTokenValue();

        return [
            'csrf'   => [
                'keys' => [
                    'name'  => $csrfNameKey,
                    'value' => $csrfValueKey
                ],
                'name'  => $csrfName,
                'value' => $csrfValue
            ]
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction(
                'csrf_token',
                [$this, 'getCsrfField'],
                ['is_safe' => ['html']]
            )
        ];
    }

    public function getCsrfField()
    {
        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();
        $name = $this->csrf->getTokenName();
        $value = $this->csrf->getTokenValue();

        return "
            <input type=\"hidden\" name=\"$nameKey\" value=\"$name\">
            <input type=\"hidden\" name=\"$valueKey\" value=\"$value\">
        ";
    }
}
