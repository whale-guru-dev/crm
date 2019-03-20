<?php

if (!function_exists('optionalString')) {


    function optionalString($string, $before = null, $after ='')
    {
        if(!empty($string)){
            return $before.$string.$after;
        }
    }
}