<?php namespace Clem\Steam\Components;

use Cms\Classes\ComponentBase;
use Clem\Steam\Api\Api;
use Clem\Steam\Api\Methods\RecentlyPlayedGames;
use Clem\Steam\Api\Methods\PlayerSummaries;
use Clem\Steam\Models\User;
use Clem\Steam\Models\Game;
use Config;
use Carbon\Carbon;


use Clem\Helpers\Debug;

/**
*   Component that shows a feed of games played on steam chronologically.
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

    //
    private function updateSteamGames(){

        if ( !$this->steamUser->games->count ) {
            //fetch games

            $this->updateSteamGames();
        }

        // retrive active games only
        $this->steamGames = $this->steamUser->games->filter(function($game){
            return $game->active;
        });
        if ( $this->gameIsExpired() ) {
            //update

        }// else return
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
        $this->buildComponent();

        $activeGames = $this->steamUser->games->filter(function($game){
            return $game->active;
        });

        $lastUpdated = $activeGames->max('updated_at');
        $this->addExpire($lastUpdated,'games');
        $now = Carbon::now();


        if ( $now->gt($lastUpdated) ) {
            echo 'udpate it';
        }else{
            echo 'don\'t update it';
        }
        exit;

        $this->dump_dates($this->steamUser->games);
        $this->dump_dates($this->steamUser->games->sortBy('updated_at'));
        exit;


        Debug::dump($this->steamUser->games);
        Debug::dump($this->steamUser->games->sortBy(function($game){
                return $game->updated_at;
        }));
        exit;

        new RecentlyPlayedGames( ['steamid' => $this->steamUser->steam_id_sixtyfour] );

        // template output
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