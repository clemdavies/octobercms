<?php namespace Clem\Steam\Models;

use Model;

/**
 * Games that a user has played recently on steam.
 */

class Games extends Model {

    protected $table = 'clem_steam_games';

    public $rules = [
        'user_id'          => array( 'required', 'unique', 'exists:user,id' ),
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
        'user' => ['User', 'foreignKey' => 'id']
    ];

}