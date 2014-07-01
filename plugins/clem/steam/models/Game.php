<?php namespace Clem\Steam\Models;

use Clem\Steam\Models\User;
use Model;
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

    public function onlyActive( $games ){
        Game::wherenot('id','1,2,3,4,')->active(false);
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