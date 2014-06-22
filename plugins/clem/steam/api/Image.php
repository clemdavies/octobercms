<?php namespace Clem\Steam\Api;

use Clem\Helpers\UrlBuilder;
use Config;

use Clem\Helpers\Debug;

/**
*
*/

class Image
{
    private $urlBuilder;

     /**
     * Call this method to get singleton
     */
    public static function create( $parameters ){
        static $instance = null;
        if ($instance === null) {
            $instance = new Image();
            $instance->urlBuilder = new UrlBuilder( $parameters, Config::get('clem.steam::api.urltemplates.image') );
        }else{
            $instance->urlBuilder->reconstruct( $parameters, Config::get('clem.steam::api.urltemplates.image') );
        }
        return $instance->urlBuilder->getUrl();
    }
    private function __construct(){
        // do nothing
    }

}