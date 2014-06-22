<?php namespace Clem\Helpers;

// helper class for debuggin purposes.
class Debug
{
    public static function dump($var){
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}