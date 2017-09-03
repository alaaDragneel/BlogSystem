<?php

if (!function_exists("dd")) {
    /**
    * Visualize The Given variable in browser
    *
    * @param mixed $var
    * @return void
    */
   function dd($var)
   {
       echo "<pre>";
       print_r($var);
       echo "</pre>";
       die;
   }
}
