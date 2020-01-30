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
        if (isset($messages['custom'])) {
            $custom = &$messages['custom'];

            expand($custom);
        }

        parent::__construct($showValidationRules, $messages);

        $this->attributes = $attributes;
    }

    public function validateInput($input, Configuration $config, array $messages = []): BaseValidator
    {
        expand($messages);

        $key = $config->getKey();
        $rules = $config->getValidationRules();

        // Add name to rules
        if (empty($rules->getName())) {
            if (isset($this->attributes[$key])) {
                $rules->setName($this->attributes[$key]);
            } else {
                $rules->setName($key);
            }
        }

        // Add custom messages
        $customMessages = $messages[$key] ?? null;
        $customMessages = $customMessages ? $customMessages : $this->defaultMessages['custom'][$key] ?? null;

        if (is_array($customMessages)) {
            $config->setMessages(
                array_merge($customMessages, $config->getMessages())
            );
        }

        // Add single parameter message
        if (is_string($customMessages)) {
            $config->setMessage($customMessages);
        }

        unset($messages[$key]);
        unset($this->defaultMessages['custom'][$key]);

        try {
            $rules->assert($input);
        } catch (NestedValidationException $e) {
            $this->handleValidationException($e, $config, $messages);
        }

        return $this->setValue($config->getKey(), $input, $config->getGroup());
    }
}
