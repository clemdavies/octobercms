<?php namespace Clem\Steam\Collections;


use Illuminate\Database\Eloquent\Collection;

Class GamesLibrary extends Collection{


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
        foreach( Config::get('clem.steam::api.expire.'.$name) as $time => $amount ){
            $method = 'add'.$time;
            $carbonObject->$method($amount);
        }
        return Carbon::now()->gt($carbonObject);
    }

    public function isGamesLibraryIsExpired(){
        return $this->isExpired( $this->gamesLibraryLastUpdate(), 'gameslibrary' );
    }
    public function isRecentlyPlayedGamesAreExpired(){
        return $this->isExpired( $this->steamGames->max( 'updated_at' ), 'recentlyplayed' );
    }



}