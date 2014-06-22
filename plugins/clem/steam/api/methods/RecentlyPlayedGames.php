<?php namespace Clem\Steam\Api\Methods;

use Clem\Steam\Api\Method;
use Clem\Steam\Api\Image;
use Clem\Steam\Api\Data;
use Clem\Helpers\UrlBuilder;
use Config;

use Clem\Helpers\Debug;

/**
*   -GetRecentlyPlayedGames (v0001)
*/

class RecentlyPlayedGames extends Method
{

    public $data;

    public function __construct( $parameters ){
        $this->setName('getrecentlyplayedgames');
        parent::__construct( $parameters );
        $this->getData();
    }

    public function getData(){
        $this->data = new Data();
        $this->data->games = array();
        $this->callUrl();
        $this->extractDataFromResponse();
    }

    private function extractDataFromResponse(){
        $this->data->count = $this->response->total_count;
        foreach($this->response->games as $i => $game){
            $object = new Data();
            $object->name  = $game->name;
            $object->playtime = new Data();
            $object->playtime->recent  = $game->playtime_2weeks;
            $object->playtime->forever = $game->playtime_forever;
            $object->image_url = Image::create(array('appid'=>$game->appid,'logoid'=>$game->img_logo_url));
            $object->game_url  = ( new UrlBuilder( array('appid'=>$game->appid), Config::get('clem.steam::api.urltemplates.game') ) )->getUrl();
            $this->data->games[$i] = $object;
        }
    }

}