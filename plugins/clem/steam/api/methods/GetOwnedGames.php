<?php namespace Clem\Steam\Api\Methods;

use Clem\Steam\Api\Method;
use Config;

use Clem\Helpers\Debug;

/**
*   -GetOwnedGames (v0001)
*/

class GetOwnedGames extends Method
{
    public $modelData;

    public function __construct( $parameters ){
        parent::__construct( $parameters );
    }

    // check ranking is available from index of returned array
    // format information i have retrieved
    public function fetchDataForGameModel(){

        $this->modelData = array();
        $this->callUrl();



        foreach($this->response->games as $i => $gameData){
            $game = Config::get('clem.steam::api.models.game.dbdatakeys');
            foreach ( $game as $dbKey => $dataKey) {
                if ( is_null($dataKey) ) {
                    continue;
                }
                if ( property_exists($gameData, $dataKey) ) {
                    $game[$dbKey] = $gameData->$dataKey;
                } else{
                    $game[$dbKey] = 0;
                }
            }
            $game['rank'] = 0;
            $game['img_logo_url'] = $gameData->img_logo_url;
            $this->modelData[] = $game;
        }

        return $this->modelData;
    }



}