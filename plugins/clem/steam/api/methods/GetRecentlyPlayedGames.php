<?php namespace Clem\Steam\Api\Methods;

use Clem\Steam\Api\Method;
use Config;

use Clem\Helpers\Debug;

/**
*   -GetRecentlyPlayedGames (v0001)
*/

class GetRecentlyPlayedGames extends Method
{
    public $modelData;

    public function __construct( $parameters ){
        Debug::dump($parameters);
        parent::__construct( $parameters );
    }

    // check ranking is available from index of returned array
    // format information i have retrieved
    public function fetchDataForGameModel(){

        $this->modelData = array();
        $this->callUrl();


        foreach($this->response->games as $i => $gameData){
            //$game = new Game();
            $game = Config::get('clem.steam::api.models.game.dbdatakeys');
            foreach ( $game as $dbKey => $dataKey) {
                if ( is_null($dataKey) ) {
                    continue;
                }
                $game[$dbKey] = $gameData->$dataKey;
            }
            $game['rank'] = $i;
            $game['img_logo_url'] = $gameData->img_logo_url;
            $this->modelData[] = $game;
            /*
            $game->name = $gameData->name;
            $game->playtime_recent  = $gameData->playtime_2weeks;
            $game->playtime_forever = $gameData->playtime_forever;
            $game->app_id = $gameData->appid;
            */

            // should be done on the model class
            //$game->app_image_url = Image::create( array('appid'=>$gameData->appid,'logoid'=>$gameData->img_logo_url) );
            //$game->app_url  = ( new UrlBuilder( array('appid'=>$gameData->appid), Config::get('clem.steam::api.urltemplates.app_game') ) )->getUrl();
            //$game->active = true;
            //$game->user_id = $this->steamUser->id;
            //$game->updateOrSave();
            //$this->steamGames->add( $game );
        }
        // deactivate all other games.
        //Game::onlyActive( $this->steamGames );
        return $this->modelData;
    }

}