<?php

if (!function_exists("dd")) {
    /**
    * Visualize The Given variable in browser
    *
    * NOTE "[ ...$params ]" For PHP 5.6 OR Above = func_get_args();
    * @param mixed $var
    * @return void
    */
    function dd(...$params)
    {
        array_map(function($var) {
            dump($var);
        }, $params); // $params = func_get_args
    }
}

if (!function_exists('array_get')) {
    /**
    * Get The Value Form The Given Array for Given Key If Found
    * Otherwise get The Default Value
    *
    * @param array $array
    * @param string|int $key
    * @param mixed $default
    * @return void
    */
    function array_get($array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

}

if (!function_exists('__e')) {
    /**
    * Escape The Given Value
    * Otherwise get The Default Value
    *
    * @param string $value
    * @return string
    */
    function __e($value)
    {
        return htmlspecialchars($value);
    }

}
