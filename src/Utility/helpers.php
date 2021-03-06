<?php

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Slim\Exception\HttpNotFoundException;

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

    if (!isset($settings[$name])) {
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

function title($title)
{
    return app_name() . ' - ' . $title;
}

function asset_image($path)
{
    return asset(FOLDER_IMAGES . '/' . $path);
}

function admin_url($path)
{
    return url('/admin' . $path);
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source https://gravatar.com/site/implement/images/php/
 */
function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array())
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function storage_url($file)
{
    return url(
        FOLDER_STORAGE . $file
    );
}

function app_logo()
{
    $logo = setting('app.logo');

    return $logo
        ? url(FOLDER_UPLOADED_IMAGES . '/' . $logo)
        : $logo;
}

function arr_only($keys)
{
    return Arr::only($array, $keys);
}

/**
 * Moves the uploaded file to the upload directory and assigns it a unique name
 * to avoid overwriting an existing uploaded file.
 *
 * @param string $directory directory to which the file is moved
 * @param UploadedFileInterface $uploaded file uploaded file to move
 * @return string filename of moved file
 * @source http://www.slimframework.com/docs/v4/cookbook/uploading-files.html
 */
function moveUploadedFile($uploadedFile, $directory = PATH_FILES)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}
