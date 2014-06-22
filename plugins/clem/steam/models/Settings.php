<?php namespace Clem\Steam\Models;

use Model;
use Config;

/**
*   This class controls settings for the steam api. such as api key.
*/

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'clem_steam_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
    // Rules for validating fields
    public $rules;

    public function __construct($model = array()){
        parent::__construct($model);
        $this->rules = array(
                'api_key'=> array('required','regex:/'.Config::get('clem.steam::api.patterns.key').'/')
            );
    }

}