<?php namespace Clem\Feed\Components\Steam\Models;

use Clem\Feed\Components\Steam\Models\User;
use Clem\Feed\Components\Steam\Api\Image;
use Clem\Feed\Components\Steam\Collections\GamesLibrary;

use Clem\Helpers\UrlBuilder;
use Clem\Helpers\Time;

use Config;
use Model;


use Clem\Helpers\Debug;
/**
 * Games that a user has played recently on steam.
 */

class Game extends Model {

    protected $table = 'clem_steam_games';

    public $rules = [
        'user_id'          => array( 'required', 'exists:clem_steam_users,id' ),
        'name'             => array( 'required' ),
        'app_id'           => array( 'required', 'integer' ),
        'app_url'          => array( 'required' ),
        'app_image_url'    => array( 'required' ),
        'rank'             => array( 'required', 'integer' ),
        'playtime_recent'  => array( 'required', 'integer' ),
        'playtime_forever' => array( 'required', 'integer' ),
        'active'           => array( 'required' )
    ];

    private static $update = ['rank','app_url','app_image_url','playtime_recent','playtime_forever','active'];

    public $belongsTo = [
        'user' => ['Clem\Feed\Components\Steam\Models\User']
    ];

    public function populateWith( $modelData ){
        foreach ( array_keys(Config::get('clem.feed.steam::api.models.game.dbdatakeys')) as $key ) {
            if ( is_null($modelData[$key]) ) continue;
            $this->$key = $modelData[$key];
        }

        if ( array_key_exists('img_logo_app_id', $modelData) ) {
            // uses logo from similarly named app
            $this->app_image_url = Image::create( array('appid'=>$modelData['img_logo_app_id'],'logoid'=>$modelData['img_logo_url']) );
        }else if( !is_null($modelData['img_logo_url']) ){
            // Has own logo
            $this->app_image_url = Image::create( array('appid'=>$this->app_id,'logoid'=>$modelData['img_logo_url']) );
        }else{
            // uses fallback no logo found logo
            $this->app_image_url =
                    ( new UrlBuilder( array('appid'=>$this->app_id), Config::get('clem.feed.steam::api.urltemplates.missing_image') ) )->getUrl();
        }

        $this->app_url  = ( new UrlBuilder( array('appid'=>$this->app_id), Config::get('clem.feed.steam::api.urltemplates.app_page') ) )->getUrl();
        $this->active = ( $this->playtime_recent != 0 );
        return $this->updateOrSave();
    }



    /*
        Updates an object with values in another object.
    */
    public function updateWith( $game ){
        if ( $game instanceof Self ) {
            foreach ( self::$update as $key ) {
                $this->$key = $game->$key;
            }
            $this->save();
        }
    }

    public static function onlyActive( $games ){
        $ids = [];
        foreach ( $games->toArray() as $game ){
            $ids[] = $game['id'];
        }
        $inactiveGames = Game::whereNotIn('id',$ids)->get();
        $inactiveGames->each(function($inactiveGame){
            $inactiveGame->active = false;
            $inactiveGame->save();
        });
    }



    /*
        if app_id exists
            update with new information
            mark as active
    */
    public function updateOrSave(){
        $existing = Self::where( 'app_id',  $this->app_id )
                        ->where( 'user_id', $this->user_id )->first();
        if ( is_null($existing) ) {
            // create record
            $this->save();
            return $this;
        }else{
            //update record
            $existing->updateWith($this);
            return $existing;
        }
    }

    public function playtimeRecentString(){
        return Time::hourMinuteString( $this->playtime_recent );
    }
    public function playtimeForeverString(){
        return Time::hourMinuteString( $this->playtime_forever );
    }

    // not used
    public static function hasLogo($app_id){
        return ( Game::where('app_id',$app_id)->exists() ) &&
               ( strlen(Game::where('app_id',$app_id)->first()->app_image_url) > 0 );
    }

    public function newCollection(array $models = array()){
        return new GamesLibrary($models);
    }

}