<?php namespace Clem\Steam\Api;

use Clem\Steam\Models\Settings;
use Config;
use RuntimeException;

/**
*   This class mediates fetching data from the official steam api.
*   Creates the relevant URL to fetch data from, fetches it and returns an associative array.
*
*   Official Steam Api documentation:
*   https://developer.valvesoftware.com/wiki/Steam_Web_API
*   API methods supported:
*   -GetRecentlyPlayedGames (v0001)
*   -GetPlayerSummaries (v0002)
*/

Final class Api
{
    // key is optional in some api requests. But required to initiliaze instance.
    private $key;

     /**
     * Call this method to get singleton
     */
    public static function instance(){
        static $instance = null;
        if ($instance === null) {
            $instance = new Api();
        }
        return $instance;
    }

    /**
     * Private constructor so nobody else can instance it
     */
    private function __construct(){
        $this->key = Settings::get('api_key');
    }

    public function steam_id64( $steamid ){
        $steamid = strtoupper($steamid);
        if ( strpos($steamid,'STEAM_') !== false ) {
            // STEAM_X:Y:Z format
            $xPos = strlen('STEAM_');
            $xLen = strpos($steamid,':',$xPos) - $xPos;
            $X = (int)substr($steamid,$xPos,$xLen);// X

            $yPos = $xPos+$xLen+1;
            $yLen = strpos($steamid,':',$yPos) - $yPos;
            $Y = (int)substr($steamid,$yPos,$yLen);// Y

            $zPos = $yPos+$yLen+1;
            $zLen = strlen($steamid) - $zPos;
            $Z = (int)substr($steamid,$zPos,$zLen);// Z

            $V = Config::get('clem.steam::api.conversion.'.$Y);

            if ( PHP_INT_SIZE !== 8 ) {
                // 64 bit
                // W=Z*2+Y
                $result = $Z*2+$Y;
            } else {
                // 32 bit
                // W=Z*2+V+Y
                $result = $Z*2+$V+$Y;
            }
        }else{
            //check for validity?
            //regex on steamid64 rule in config
            throw new RuntimeException('Steamid Already converted how to test though?');
        }

        return $result;
    }

    public function getKey() {
        return $this->key;
    }
}