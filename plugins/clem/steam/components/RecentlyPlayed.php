<?php namespace Clem\Steam\Components;

use Cms\Classes\ComponentBase;
use Clem\Steam\Api\Api;
use Clem\Steam\Api\Methods\RecentlyPlayedGames;
use Clem\Steam\Api\Methods\PlayerSummaries;
use Clem\Steam\Models\User;
use Clem\Steam\Models\Games;
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
        return [
            'steam_id_input' => [
                'description'       => 'The Steam account ID to collect recently played information.',
                'title'             => 'steam_id_input',
                'default'           => 'STEAM_0:1:2 OR xxxx',
                'type'              => 'string',
                'validationPattern' => Config::get('clem.steam::api.patterns.steam_id_input'),
                'validationMessage' => 'The Steam Account ID is required. Format: STEAM_X:1:Y. X = [0-5] and Y = A number. Or a 64 bit representation of xxxxxxxx where x is a number.'
            ]
        ];
    }
    // test for invalid user creation from an invalid steam_id_input
    public function updateProperties(){
        $this->steamUser = User::where( 'steam_id_input',$this->property('steam_id_input') )->first();
        if ( is_null($this->steamUser) ) {
            $this->createUser();
        }
        Debug::dump($this->steamUser->games);
        exit;
    }
    // only save user to database if player information is succesfully fetched from the steam pi
    private function createUser(){
        $player = new PlayerSummaries( $this->properties );
        $userData = $player->getDataForUserModel( );
        $this->steamUser = User::create($userData);
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