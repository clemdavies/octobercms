<?php namespace Clem\Steam\Models;

use Model;

/**
 * A user on Steam.
 */

class User extends Model {

    protected $table = 'clem_steam_users';

    public $rules = [
        'steam_id_input'     => array( 'required' ),
        'steam_id_sixtyfour' => array( 'required', 'unique' ),
        'persona_name'       => array( 'required' ),
        'persona_state'      => array( 'required', 'integer' ),
        'profile_url'        => array( 'required' ),
        'profile_image_url'  => array( 'required' )
    ];

    public $hasMany = [
        'games' => ['Games', 'primaryKey' => 'id']
    ];
}