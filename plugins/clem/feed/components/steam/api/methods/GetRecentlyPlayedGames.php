<?php namespace Clem\Feed\Components\Steam\Api\Methods;

use Clem\Feed\Components\Steam\Api\Method;
use Config;

use Clem\Helpers\Debug;

/**
*   -GetRecentlyPlayedGames (v0001)
*/

class GetRecentlyPlayedGames extends Method
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
            //$game = new Game();
            $game = Config::get('clem.feed.steam::api.models.game.dbdatakeys');
            foreach ( $game as $dbKey => $dataKey) {
                if ( is_null($dataKey) ) {
                    continue;
                }
                $game[$dbKey] = $gameData->$dataKey;
            }
            $game['rank'] = $i;
            $game['img_logo_url'] = $gameData->img_logo_url;
            $this->modelData[] = $game;
        }
        return $this->modelData;
    }

}