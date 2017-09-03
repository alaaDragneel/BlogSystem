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
