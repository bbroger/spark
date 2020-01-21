<?php

namespace App\Controllers;

use App\Exceptions\ValidationException;
use Psr\Container\ContainerInterface;

class Controller
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        return $this->container->get($property);
    }

    public function validate(
        $input, 
        $rules, 
        $messages = [],
        $group = null, 
        $default = []
    )
    {
        $validator = $this->validator;

        $validator->validate($input, $rules, $group, $messages, $default);

        if (! $validator->isValid()) {
            $errors = $validator->getErrors();

            $this->flash->withErrors($errors)
                ->withInputs($validator->getValues());

            throw new ValidationException($errors);
        }
    }
}
