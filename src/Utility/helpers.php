<?php

/**
 * Gets the value of a environment variable.
 * 
 * @param string $var
 * @param mixed $default
 * @return mixed
 */
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
