<?php

use Illuminate\Support\Str;

function env_get($var, $default = '')
{
    $value = getenv($var) ?? $default;

    switch ($value) {
        case 'true':
            return true;

        case 'false':
            return false;
    }

    return $value;
}

function expand(&$array)
{
    foreach ($array as $key => $value) {
        data_set($array, $key, $value);

        if (Str::contains($key, '.')) {
            unset($array[$key]);
        }
    }

    return $array;
}