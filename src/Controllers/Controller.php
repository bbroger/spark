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

    /**
     * Validate an given input.
     * 
     * Example:
     * 
     *  $this->validate($request, [
     *      'name' => v::notBlank(),
     *      'body' => v::notBlank()->numeric()
     *  ], [
     *      'name.notBlank' => 'A mensagem para a regra notBlank do name',
     *      'body' => 'O corpo precisa ser preenchido e ser numérico!'
     *  ]);
     * 
     * @see config/validation.php
     * @see https://github.com/awurth/SlimValidation
     */
    public function validate(
        $input, 
        $rules, 
        $messages = [], /* Custom messages */
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
