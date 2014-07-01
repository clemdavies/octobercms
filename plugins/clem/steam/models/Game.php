<?php namespace Clem\Steam\Models;

use Clem\Steam\Models\User;
use Clem\Steam\Api\Image;
use Clem\Helpers\UrlBuilder;
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

    private static $update = ['rank','playtime_recent','playtime_forever','active'];

    public $belongsTo = [
        'user' => ['Clem\Steam\Models\User']
    ];

    public function populateWith( $modelData ){
        foreach ( $modelData as $key => $value ) {
            if ( is_null($value) ) continue;
            $this->$key = $value;
        }
        $this->app_image_url = Image::create( array('appid'=>$this->app_id,'logoid'=>$modelData['img_logo_url']) );
        $this->app_url  = ( new UrlBuilder( array('appid'=>$this->app_id), Config::get('clem.steam::api.urltemplates.app_game') ) )->getUrl();
        $this->active = true;
        $this->updateOrSave();
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
        Debug::dump( Game::whereNotIn('id',$ids) );exit;
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
        }else{
            //update record
            $existing->updateWith($this);
        }
    }

}