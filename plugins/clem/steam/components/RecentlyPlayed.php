<?php namespace Clem\Steam\Components;

use Cms\Classes\ComponentBase;
use Clem\Steam\Api\Api;
use Clem\Steam\Api\Methods\RecentlyPlayedGames;
use Clem\Steam\Api\Methods\PlayerSummaries;
use Clem\Steam\Models\User;
use Config;
use Clem\Helpers\Debug;

/**
*   Component that shows a feed of games played on steam chronologically.
*/

class RecentlyPlayed extends ComponentBase
{
    private $steamUser;

    public function componentDetails()
    {
        return [
            'name'        => 'Steam Recently Played',
            'description' => 'Shows a single user\'s recently played games from Steam.'
        ];
    }

    // instance based settings
    public function defineProperties()
    {
        //echo preg_match(Config::get('clem.steam::patterns.steam_id_input'), 'STEAM_0:1:32417108');
        //exit;
        return [
            'steam_id_input' => [
                'description'       => 'The Steam account ID to collect recently played information.',
                'title'             => 'steam_id_input',
                'default'           => 'STEAM_0:1:2 OR xxxx',
                'type'              => 'string',
                'validationPattern' => Config::get('clem.steam::api.patterns.steam_id_input'),
                'validationMessage' => 'The Steam Account ID is required. Format: STEAM_X:1:Y. X = [0-5] and Y = A number. Or a 64 bit representation of xxxxxxxx where x is a number.'
            ]
            /*,'count' => [
                'description'       => 'The maximum number of games to display.',
                'title'             => 'Maximum Number Of Games',
                'default'           => '5',
                'type'              => 'string',
                'validationPattern' => 'Config::get(clem.steam::patterns.count)',
                'validationMessage' => 'Maximum number of games must be [1-10].'
            ]*/
        ];
    }
    // add conversion for starting index and ending index?
    public function updateProperties(){
        $this->steamUser = User::where( 'steam_id_input',$this->property('steam_id_input') )->get();
        if ( $this->steamUser->isEmpty() ) {
            $this->createUser();
        }
    }
    // only save user to database if player information is succesfully fetched from the steam pi
    private function createUser(){
        $api = Api::instance();

        $steam_id_input = $this->property( 'steam_id_input' );
        $steamid        = $api->steam_id64( $steam_id_input );

        $this->setProperty( 'steamid',$steamid );

        $player = new PlayerSummaries( $this->properties );
        $data = $player->getData();

        Debug::dump($data);
        exit;

        $steamUser = new User($data);

    }

    public function onRun()
    {
        $this->updateProperties();
        $games = new RecentlyPlayedGames( $this->properties );
        Debug::dump($games);
        exit;

        $this->page['username'] = $this->getUser();
        $this->page['games'] = $this->getGames();
    }

    private function getUser(){
        $steam_id_input = $this->property('steam_id_input');
        $username = 'SquealPig';
        return $username;
    }

    private function getGames(){
        $games = Array();
        for ($i=0; $i < 5; $i++) {
            $game = Array();
            $game['name'] = 'CS:GO';
            $game['icon'] = 'CSGO-ICON';
            $games[] = $game;
        }
        return $games;
    }

}