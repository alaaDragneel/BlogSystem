<?php

if (!function_exists("dd")) {
    /**
    * Visualize The Given variable in browser
    *
    * @param mixed $var
    * @return void
    */
    function dd()
    {
        array_map(function($var) {
            dump($var);
        }, func_get_args());
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
