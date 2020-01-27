<?php

namespace App\Session;

use Slim\Flash\Messages;

class Flash extends Messages
{
    public function put($key, $message)
    {
        $this->storage[$this->storageKey][$key] = $message;

        return $this;
    }

    public function getStorage()
    {
        return $this->storage;
    }

    public function now($key, $message)
    {
        $this->forNow[$key] = $message;

        return $this;
    }

    public function push($key, $message)
    {
        return $this->addMessage($key, $message);
    }

    public function pushNow($key, $message)
    {
        return $this->addMessageNow($key, $message);
    }

    public function first($key, $default = null)
    {
        return $this->getFirstMessage($key, $default);
    }

    public function get($key, $default = null)
    {
        return $this->getMessage($key) ?? $default;
    }

    public function has($key)
    {
        return $this->hasMessage($key);
    }

    public function setInputs($inputs)
    {
        $this->put('_inputs', $inputs);

        return $this;
    }

    public function old($key, $default = null)
    {
        return $this->get('_inputs', [])[$key] ?? $default;
    }

    public function setErrors($errors)
    {
        $this->put('_errors', $errors);

        return $this;
    }

    public function addError($key, $value)
    {
        $errors = $this->getErrors();

        $errors[$key] = $value;

        $this->setErrors($errors);

        return $this;
    }

    public function getErrors($default = [])
    {
        return $this->get('_errors', $default);
    }

    public function setPreviuousUrl($url)
    {
        $this->put('_previuous_url', $url);
    }

    public function getPreviousUrl()
    {
        return $this->get('_previuous_url');
    }
}
