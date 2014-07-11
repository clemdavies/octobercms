<?php namespace Clem\Steam\Components;

use Cms\Classes\ComponentBase;
use Clem\Steam\Api\Api;
use Clem\Steam\Api\Methods\GetRecentlyPlayedGames;
use Clem\Steam\Api\Methods\GetPlayerSummaries;
use Clem\Steam\Api\Methods\GetOwnedGames;
use Clem\Steam\Models\User;
use Clem\Steam\Models\Game;
use Carbon\Carbon;
use Config;
use Illuminate\Database\Eloquent\Collection;


use Clem\Helpers\Debug;

/**
*   Component that shows a feed of games played on steam chronologically.
*
*   Will Break if no games are found on user
*   Might break if steam_id_input fails to find a user on steam.
*/

class RecentlyPlayed extends ComponentBase
{
    // Clem\Steam\Models\User instance
    private $steamUser;

    // Eloquant\Collection of Clem\Steam\Models\Game instances
    private $steamGames;

    // failsafe for only calling steam api to fetch once. if expiration time is set wrong or bugs out.
    private $gamesFetched;


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

    // octoberCms calls this method?
    public function updateProperties(){
        $this->updateSteamUser();
        $this->updateSteamGames();
    }

    // test for invalid user creation from an invalid steam_id_input
    private function updateSteamUser(){
        $this->steamUser = User::where( 'steam_id_input',$this->property('steam_id_input') )->first();
        if ( is_null($this->steamUser) ) {
            // create user
            $player = new GetPlayerSummaries( $this->properties );
            $userData = $player->fetchDataForUserModel();
            $this->steamUser = User::create( $userData );
        }else if( $this->userIsExpired() ) {
            // update user
            $player = new GetPlayerSummaries( $this->properties );
            $userData = $player->fetchDataForUserModel();
            $this->steamUser->updateWith( $userData );
        }
    }

    // will infinitely loop if no games can be fetched.
    private function updateSteamGames(){

        $this->steamGames = $this->steamUser->games;// here?

        if ( !$this->steamGames->count() ) {
            // games library doesnt exist
            $this->fetchGamesLibrary();
        }else if( $this->gamesLibraryIsExpired() ){
            // games library needs updating
            $this->fetchGamesLibrary();
        }else if ( $this->recentlyPlayedGamesAreExpired() ) {
            // recently played games needs updating
            $this->fetchRecentlyPlayed();
        }

        //$this->steamGames repopulated with ALL games
        // gamesLibrary exists and is up to date AND recently played is up to date

        $this->sortGameLibrary();
    }


    /*
        Sorts the user's game library into a logical descending order
        RecentlyPlayed displays first from most played to least played
        Then all other games displayed from most played off all time to least played
    */
    private function sortGameLibrary(){

        // ACTIVE sorted by playtime_recent DESC
        $activeGames = $this->steamGames->filter(function($game){
            return $game->active;
        });
        $activeGames->sort(function($a, $b)
        {
            if ($a->playtime_recent === $b->playtime_recent) {
                // sort alphabetically
                return strcasecmp ( $a->name , $b->name );
            }
            return ($a->playtime_recent < $b->playtime_recent) ? 1 : -1;
        });

        // INACTIVE sorted by playtime_forever DESC
        $inactiveGames = $this->steamGames->filter(function($game){
            return !$game->active;
        });
        $inactiveGames->sort(function($a, $b)
        {
            if ($a->playtime_forever === $b->playtime_forever) {
                // sort alphabetically
                return strcasecmp ( $a->name , $b->name );
            }
            return ($a->playtime_forever < $b->playtime_forever) ? 1 : -1;
        });


        $this->steamGames = $activeGames->merge($inactiveGames);
    }

    private function fetchGameData( $methodObject ){
        $gameModelDataArray = $methodObject->fetchDataForGameModel();
        $gameModelDataArray = $this->resolveImages($gameModelDataArray);
        foreach ( $gameModelDataArray as $gameModelData ) {
            $game = new Game();
            $gameModelData['user_id'] = $this->steamUser->id;
            $game = $game->populateWith( $gameModelData );
            $this->steamGames->add( $game );
        }
        $this->gamesFetched = true;
    }

    /*
        Resolves any missing images for games such as Dota 2 test and Left 4 Dead 2 beta
        These are given a closely matching game's logo.
        If still no logo is found the template will resolve this by using a missing-logo logo delivered via css
    */
    private function resolveImages($modelData){
        foreach ($modelData as $i => $game) {
            /*
            No longer used. can be used to cut processing time
            if ( Game::hasLogo($game['app_id'])){
                // game logo has been resolved.
                continue;
            }
            */

            if ($game['img_logo_url'] == '') {

                $name = $game['name'];
                $matches = [];
                foreach ($modelData as $i2 => $game2) {
                    if ($game2 === $game) continue;
                    if ( preg_match('~' . $game2['name'] . '~', $name ) ) {
                        $matches[] = $i2;
                    }
                }
                if (count($matches) > 0) {
                    if (count($matches) == 1) {
                        $modelData[$i]['img_logo_url'] = $modelData[$matches[0]]['img_logo_url'];
                        $modelData[$i]['img_logo_app_id'] = $modelData[$matches[0]]['app_id'];
                    }else{
                        $longestName = '';
                        $longestMatch = 0;
                        foreach ($matches as $match) {
                            if (strlen( $modelData[$match]['name'] ) > '' ) {
                                $longestName = $modelData[$match]['name'];
                                $longestMatch = $match;
                            }
                        }
                        $modelData[$i]['img_logo_url'] = $modelData[$longestMatch]['img_logo_url'];
                        $modelData[$i]['img_logo_app_id'] = $modelData[$longestMatch]['app_id'];
                    }
                }
            }
        }
        return $modelData;
    }

    // calls the steam api to retrive a list of recently played games
    private function fetchRecentlyPlayed(){
        $recentlyPlayedGames = new GetRecentlyPlayedGames( ['steamid' => $this->steamUser->steam_id_sixtyfour] );
        $this->fetchGameData( $recentlyPlayedGames );
    }

    // calls the steam api to retrieve a list of all games in user's games library
    private function fetchGamesLibrary(){
        $gamesLibrary = new GetOwnedGames( ['steamid' => $this->steamUser->steam_id_sixtyfour] );
        $this->fetchGameData( $gamesLibrary );
    }


    private function expiresAt(){

    }

    private function updateDueAt(){
        //lastupdatedtime + expiretime = nextupdate_sinceepoch

        $updates = [
            $this->expiresAt( $this->gamesLibraryLastUpdate(),'gameslibrary' ) ,
            $this->expiresAt( $this-> recentlyPlayedLastUpdate(),'recentlyplayed' ),
            $this->expiresAt( $this->userLastUpdate(),'user' )
        ];

        $next = 0;

        foreach($updates as $time){
            $current = $now->diff($time);
            if ($next == 0 || ($current > 0 && $current < $next) ) {
                $next = $current;
            }
        }


        return $carbonObject->timestamp;
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

    private function gamesLibraryIsExpired(){
        return $this->isExpired( $this->gamesLibraryLastUpdate(), 'gameslibrary' );
    }
    private function recentlyPlayedGamesAreExpired(){
        return $this->isExpired( $this->steamGames->max( 'updated_at' ), 'recentlyplayed' );
    }
    private function userIsExpired(){
        return $this->isExpired( $this->steamUser->updated_at, 'user' );
    }




    private function gamesLibraryLastUpdate(){
        return $this->steamGames->min( 'updated_at');
    }
    private function recentlyPlayedLastUpdate(){
        return $this->steamGames->max( 'updated_at');
    }

    private function userLastUpdate(){
        return $this->steamUser->updated_at;
    }


    /*
        Runs on page load
    */
    public function onRun(){

        // on page load render empty template with steamuser for header

        // heavylifting is done during ajax request

        // ajax request is sent to fetch gameslist from (posX,posY); initially 1->5?
        // then each scroll click fetches next or previous 5 in list. rerenders/updates



        $this->updateSteamUser();
        $this->updateSteamGames();

        // load template variables
        $this->page['user']  = $this->steamUser;

        $start = 0;
        $count = 10;
        $gameSet = $this->steamGames->slice($start,$count);

        $this->page['games'] = $gameSet;



        //default.htm is queued for output and loaded with data.
    }

    public function onAjax(){

        $start = post('start');
        $count = post('count');
        $direction = post('direction');

        $this->updateSteamUser();
        $this->updateSteamGames();

        // load template variables
        $this->page['user']  = $this->steamUser;
        $this->page['games'] = $this->steamGames;
    }

    public function onTest(){
        $value1 = post('value1');
        $value2 = post('value2');
        $this->result = $value1 + $value2;
    }

}