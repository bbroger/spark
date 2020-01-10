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
    return getenv($var) ?? $default;
}
