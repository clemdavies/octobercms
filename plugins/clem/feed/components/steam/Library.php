<?php namespace Clem\Feed\Components\Steam;

use Clem\Feed\Components\Steam\Api\Api;
use Clem\Feed\Components\Steam\Api\Methods\GetRecentlyPlayedGames;
use Clem\Feed\Components\Steam\Api\Methods\GetPlayerSummaries;
use Clem\Feed\Components\Steam\Api\Methods\GetOwnedGames;
use Clem\Feed\Components\Steam\Models\User;
use Clem\Feed\Components\Steam\Models\Game;

use Cms\Classes\ComponentBase;
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

class Library extends ComponentBase
{
    use \Clem\Traits\ScssAssetMaker;

    // Clem\Steam\Models\User instance
    private $steamUser;

    // Eloquant\Collection of Clem\Steam\Models\Game instances
    private $steamGames;

    // failsafe for only calling steam api to fetch once. if expiration time is set wrong or bugs out.
    private $gamesFetched;

    // bool indicating if user or games has been updated.
    private $userUpdated;
    private $gamesUpdated;


    public function componentDetails()
    {
        return [
            'name'        => 'Steam Library',
            'description' => 'Shows a single user\'s game library from Steam with playtimes.'
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
                'validationPattern' => Config::get('clem.feed.steam::api.patterns.steam_id_input'),
                'validationMessage' => 'The Steam Account ID is required. Format: STEAM_X:1:Y. X = [0-5] and Y = A number. Or a 64 bit representation of xxxxxxxx where x is a number.'
            ]
        ];
    }

    // octoberCms calls this method?
    public function updateProperties(){
        //$this->updateSteamUser();
        //$this->updateSteamGames();
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

        $this->steamGames->order();
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
        foreach( Config::get('clem.feed.steam::api.expire.'.$name) as $time => $amount ){
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

        $this->addJs('/plugins/clem/feed/components/steam/assets/javascript/library.js');
        $this->addCss('/plugins/clem/feed/components/steam/assets/stylesheet/library.less');
        $this->addCss('/plugins/clem/feed/components/assets/stylesheet/feed.css');

        //$this->updateSteamUser();
        //$this->page['user']  = $this->steamUser;

        //default.htm is queued for output and loaded with data.
    }

    private function readyForUpdate(){
        return false;
    }


    public function onAppend(){

        $lastRank = (int)post('rank');

        $this->updateSteamUser();
        $this->updateSteamGames();

        $this->userUpdated = false;
        $this->gamesUpdated = false;

        /*
            if(update){
                return new set of n(5) values
            }else{
                return next 1
            }
        */

        $nextRank = $lastRank + 1;

        foreach ($this->steamGames as $key => $game) {
            if ( (int) $game->rank == ($nextRank) )  {
                $start = $key;
                break;
            }
        }
        $game = $this->steamGames->get($start);

        return [
            'item' => $this->controller->renderPartial('feedsteamlibrary::item',['game'=>$game])
        ];


    }

    public function onInit(){

        $this->updateSteamUser();
        $this->updateSteamGames();

        // load template variables
        //$this->page['user']  = $this->steamUser;
        $start = 0;
        $count = 5;
        $gameSet = $this->steamGames->slice($start,$count);
        //$this->page['games'] = $gameSet;


        return [
            'update' => true,
            'head' => $this->controller->renderPartial('feedsteamlibrary::head',['user' => $this->steamUser] ),
            'body' => $this->controller->renderPartial('feedsteamlibrary::body',['games' => $gameSet] )
        ];

    }



    /**
     * Adds StyleSheet asset to the asset list. Call $this->makeAssets() in a view
     * to output corresponding markup.
     * @param string $name Specifies a path (URL) to the script.
     * @param array $attributes Adds extra HTML attributes to the asset link.
     * @return void
     */
    public function addLess($name, $attributes = [])
    {
        $cssPath = $this->getAssetPath($name);

        if (isset($this->controller))
            $this->controller->addCss($cssPath, $attributes);

        if (is_string($attributes))
            $attributes = ['build' => $attributes];

        if (substr($cssPath, 0, 1) == '/')
            $cssPath = Request::getBaseUrl() . $cssPath;

        if (!in_array($cssPath, $this->assets['css']))
            $this->assets['css'][] = ['path' => $cssPath, 'attributes' => $attributes];
    }

}