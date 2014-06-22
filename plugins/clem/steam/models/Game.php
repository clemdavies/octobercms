<?php namespace Clem\Steam\Models;

use Clem\Steam\Models\User;
use Model;
/**
 * Games that a user has played recently on steam.
 */

class Game extends Model {

    protected $table = 'clem_steam_games';

    public $rules = [
        'user_id'          => array( 'required', 'unique:clem_steam_games,user_id', 'exists:user,id' ),
        'name'             => array( 'required' ),
        'app_id'           => array( 'required', 'integer' ),
        'app_url'          => array( 'required' ),
        'app_image_url'    => array( 'required' ),
        'rank'             => array( 'required', 'integer' ),
        'playtime_forever' => array( 'required', 'integer' ),
        'playtime_recent'  => array( 'required', 'integer' ),
        'active'           => array( 'required', 'boolean' )
    ];

    public $belongsTo = [
        'user' => ['User']
    ];

}