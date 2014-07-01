<?php namespace Clem\Steam\Api\Methods;

use Clem\Steam\Api\Method;
use Config;

use Clem\Helpers\Debug;

/**
*   -GetPlayerSummaries (v0002)
*/

// does NOT support multiple steamids at this time.
class GetPlayerSummaries extends Method
{
    protected $steamIdInput;

    public function __construct( $parameters ){
        parent::__construct( $parameters );
    }

    protected function preAddParameters(){
        $this->formatApiKeys();
    }

    // convuluted and probably unnecessary
    private function formatApiKeys(){
        foreach ( $this->passedParameters as $key => $value) {
            if ( $key == 'steamid' || $key == 'steamids' ) {
                if ( is_array($value) ) {
                    $value = implode(',', $value);
                }
                if ( array_key_exists('steamids',$this->passedParameters) ) {
                    $this->passedParameters['steamids'] .= ',' . $value;
                }else{
                    $this->passedParameters['steamids'] = $value;
                }
            }
        }
    }

    // only works with a single user
    public function fetchDataForUserModel( ){
        $this->callUrl();

        $modelData = Config::get('clem.steam::api.models.user.dbdatakeys');

        foreach ( $modelData as $dbKey => $dataKey) {
            if ( is_null($dataKey) ) {
                continue;
            }
            $modelData[$dbKey] = $this->response->players[0]->$dataKey;
        }
        $modelData['steam_id_input'] = $this->steamIdInput;

        return $modelData;
    }




    public function setSteamIdInput( $newSteamIdInput ){
        $this->$steamIdInput = $newSteamIdInput;
    }
    public function getSteamIdInput(){
        return $this->steamIdInput;
    }


}