<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception 
{
    private $errors;
    private $inputs;

    public function __construct($errors, $inputs)
    {
        parent::__construct('The given data was invalid.', 422);

        $this->errors = $errors;
        $this->inputs = $inputs;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getInputs()
    {
        return $this->inputs;
    }
}