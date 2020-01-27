<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class UniqueFieldException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => '{{name}} has already been taken.',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => '{{name}} has not been used.',
        ]
    ];
}
