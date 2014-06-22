<?php namespace Clem\Steam\Models;

use Clem\Steam\Models\Game;
use Model;


/**
 * A user on Steam.
 */

class User extends Model {

    protected $table = 'clem_steam_users';

    protected $fillable = [
        'steam_id_input',
        'steam_id_sixtyfour',
        'persona_name',
        'persona_state',
        'profile_url',
        'profile_image_url'];

    public $rules = [
        'steam_id_input'     => array( 'required' ),
        'steam_id_sixtyfour' => array( 'required', 'unique:clem_steam_users,steam_id_sixtyfour' ),
        'persona_name'       => array( 'required' ),
        'persona_state'      => array( 'required', 'integer' ),
        'profile_url'        => array( 'required' ),
        'profile_image_url'  => array( 'required' )
    ];

    public $hasMany = [
        'games' => ['Clem\Steam\Models\Game']
    ];

}