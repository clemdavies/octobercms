<?php namespace Clem\Steam\Api;

class Data
{
    public function __construct(){
        // do nothing
    }

    public function json(){
        return json_encode($this);
    }

}