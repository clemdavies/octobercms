<?php namespace Clem\Feed\Components\Steam\Collections;

use Illuminate\Database\Eloquent\Collection;
use DB;

Class GamesLibrary extends Collection{


    // assigns all games a unique ranking AFTER sorting
    public function updateRanks(){

        $update = 'UPDATE clem_steam_games
                        SET rank = CASE id';
        $in = '';
        $i = 1;
        foreach ($this as $game) {
            $game->rank = $i;
            $update .= ' WHEN ' . $game->id . ' THEN ' . $game->rank .'
            ';
            $in .= $game->id . ',';
            $i++;
        }
        $update.= 'END WHERE id IN ('.substr($in,0,strlen($in)-1).')';
        DB::statement($update);
    }

     /*
        Sorts the user's game library into a logical descending order
        RecentlyPlayed displays first from most played to least played
        Then all other games displayed from most played off all time to least played
    */
    public function order(){

        // ACTIVE sorted by playtime_recent DESC
        $activeGames = $this->filter(function($game){
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
        $inactiveGames = $this->filter(function($game){
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

        $newCollection = $activeGames->merge($inactiveGames);
        foreach ($this as $key => $game) {
            $this->forget($key);
        }
        foreach ($newCollection as $newGame) {
            $this->push($newGame);
        }
        $this->updateRanks();
    }

    /*
        Information to return

        1 boolean is gameslibrary expired?
        2 boolean is recentlyplayed expired?

        3 unix timestamp for the next update


    */

    public function nextUpdateTimestamp(){

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

    // do these work????????
    public function isGamesLibraryIsExpired(){
        return $this->isExpired( $this->gamesLibraryLastUpdate(), 'gameslibrary' );
    }
    public function isRecentlyPlayedGamesAreExpired(){
        return $this->isExpired( $this->max( 'updated_at' ), 'recentlyplayed' );
    }



}