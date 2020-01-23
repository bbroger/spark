<?php

use App\Models\Setting;
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

function setting($name)
{
    static $settings;

    if (! isset($settings[$name])) {
        $settings[$name] = Setting::where('name', $name)->first()->value ?? null;
    }

    return $settings[$name];
}

function app_name()
{
    return setting('app.name') ?? env_get('APP_NAME');
}

function app_url()
{
    return setting('app.url') ?? env_get('APP_URL');
}

function url($path = '')
{
    return app_url() . $path;
}

function get_url_scheme()
{
    return (!empty($_SERVER['HTTPS']) 
        && $_SERVER['HTTPS'] !== 'off' 
        || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
}

function asset($path)
{
    return preg_replace('/http:\/\/|https:\/\//', get_url_scheme(), url($path));
}

function asset_css($path)
{
    return asset(FOLDER_CSS . '/' . $path);
}

function asset_js($path)
{
    return asset(FOLDER_JS . '/' . $path);
}