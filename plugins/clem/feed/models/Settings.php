<?php namespace Clem\Feed\Models;

use Model;
use Config;

/**
*   This class controls settings for the steam api. such as api key.
*/

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'clem_feed_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
    // Rules for validating fields
    public $rules;

    public function __construct($model = array()){
        parent::__construct($model);
        $this->rules = array(
                'steam_api_key'=> array('regex:/'.Config::get('clem.feed::patterns.steam_key').'/'),
                'github_api_key'=> array('regex:/'.Config::get('clem.feed::patterns.github_key').'/')
            );
    }
}