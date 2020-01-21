<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception 
{
    private $errors;

    public function __construct($errors)
    {
        parent::__construct('The given data was invalid.', 422);

        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}