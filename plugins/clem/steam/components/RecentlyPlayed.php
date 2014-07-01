<?php namespace Clem\Steam\Components;

use Cms\Classes\ComponentBase;
use Clem\Steam\Api\Api;
use Clem\Steam\Api\Methods\GetRecentlyPlayedGames;
use Clem\Steam\Api\Methods\GetPlayerSummaries;
use Clem\Steam\Models\User;
use Clem\Steam\Models\Game;
use Config;
use Carbon\Carbon;


use Clem\Helpers\Debug;

/**
*   Component that shows a feed of games played on steam chronologically.
*
*   Will Break if no games are found on user
*   Might break if steam_id_input fails to find a user on steam.
*/

class RecentlyPlayed extends ComponentBase
{
    private $steamUser;
    private $steamGames;

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
    public function updateProperties(){
        $this->updateSteamUser();
        $this->updateSteamGames();
    }

    // test for invalid user creation from an invalid steam_id_input
    private function updateSteamUser(){
        $this->steamUser = User::where( 'steam_id_input',$this->property('steam_id_input') )->first();
        if ( is_null($this->steamUser) ) {
            // create user
            $player = new PlayerSummaries( $this->properties );
            $userData = $player->fetchDataForUserModel();
            $this->steamUser = User::create( $userData );
        }else if( $this->userIsExpired() ) {
            // update user
            $player = new PlayerSummaries( $this->properties );
            $userData = $player->fetchDataForUserModel();
            $this->steamUser->updateWith( $userData );
        }
    }

    // will infinitely loop if no games can be fetched.
    private function updateSteamGames(){

        // if no games exist fetch them
        if ( !$this->steamUser->games->count() ) {
            //fetch games
            $this->fetchSteamGames();
            $this->updateSteamGames();//?neccesery
        }


        // retrive active games only
        $this->steamGames = $this->steamUser->games->filter(function($game){
            return $game->active;
        });
        if ( $this->gameIsExpired() ) {
            $this->fetchSteamGames();
            $this->updateSteamGames();//?neccesery
        }
    }

    private function fetchSteamGames(){
        $recentlyPlayedGames = new GetRecentlyPlayedGames( ['steamid' => $this->steamUser->steam_id_sixtyfour] );
        $gameModelDataArray = $recentlyPlayedGames->fetchDataForGameModel();
        foreach ( $gameModelDataArray as $gameModelData ) {
            $game = new Game();
            $gameModelData['user_id'] = $this->steamUser->id;
            $game->populateWith( $gameModelData );
            $this->steamGames->add( $game );
        }
        Game::onlyActive( $this->steamGames );
    }

    private function dump_dates($collection){
        echo 'start<br/>';
        foreach ($collection as $object) {
            Debug::dump($object->name);
            Debug::dump($object->created_at);
        }
        echo 'done<br/>';
    }

    /**
     *   Carbon add methods alters instance
     *   @return boolean
     */
    private function isExpired($carbonObject,$name){
        foreach( Config::get('clem.steam::api.expire.'.$name) as $time => $amount ){
            $method = 'add'.$time;
            $carbonObject->$method($amount);
        }
        return Carbon::now()->gt($carbonObject);
    }
    private function gameIsExpired(){
        return $this->isExpired( $this->steamGames->max( 'updated_at' ), 'game' );
    }
    private function userIsExpired(){
        return $this->isExpired( $this->steamUser->updated_at, 'user' );
    }


    /*
        determine if user needs to be updated
        determine if games need to be updated
        build output from template
    */
    public function onRun(){
        $this->updateSteamUser();
        $this->updateSteamGames();

        Game::onlyActive( $this->steamGames );
        exit;

        //$this->buildComponent();

        $activeGames = $this->steamUser->games->filter(function($game){
            return $game->active;
        });

        // template output
        $this->page['username'] = $this->getUser();
        $this->page['games'] = $this->getGames();
    }

    private function addSteamGame( $game ){
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