<?php

namespace App\Validation;

use Awurth\SlimValidation\Configuration;
use Awurth\SlimValidation\Validator as BaseValidator;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator extends BaseValidator
{
    private $attributes;

    public function __construct($showValidationRules, $messages, $attributes)
    {
        parent::__construct($showValidationRules, $messages);

        $this->attributes = $attributes;
    }

    public function validateInput($input, Configuration $config, array $messages = []): BaseValidator
    {
        try {
            $key = $config->getKey();
            $rules = $config->getValidationRules();

            if (empty($rules->getName())) {
                if (isset($this->attributes[$key])) {
                    $rules->setName($this->attributes[$key]);
                } else {
                    $rules->setName($key);
                }
            }

            $rules->assert($input);
        } catch (NestedValidationException $e) {
            $this->handleValidationException($e, $config, $messages);
        }

        return $this->setValue($config->getKey(), $input, $config->getGroup());
    }
}
