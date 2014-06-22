<?php namespace Clem\Steam\Api\Methods;

use Clem\Steam\Api\Method;

/**
*   -GetPlayerSummaries (v0002)
*/

// does NOT support multiple steamids at this time.
class PlayerSummaries extends Method
{
    public function __construct( $parameters ){
        $this->setName('getplayersummaries');
        $parameters = $this->formatParametersWithSteamIds( $parameters );
        parent::__construct( $parameters );
    }

    private function formatParametersWithSteamIds($parameters){

        foreach ($parameters as $key => $value) {
            if ( $key == 'steamid' || $key == 'steamids' ) {
                if ( is_array($value) ) {
                    $value = implode(',', $value);
                }
                $parameters['steamids'] = $value;
            }
        }

        return $parameters;
    }

    public function getData(){
        $this->callUrl();
        return $this->response;
    }

}