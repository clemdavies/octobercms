<?php namespace Clem\Helpers;

// helper class for debuggin purposes.
class Time
{
    public static $hour = 'hr';
    public static $hours = 'hrs';
    public static $minute = 'min';
    public static $minutes = 'mins';

    public static function hourMinuteString($totalMinutes){
        $hours = floor( $totalMinutes / 60 );
        $minutes = $totalMinutes % 60;

        if ($hours == 0) {
            $hourString = '';
        }else if($hours == 1){
            $hourString = $hours . self::$hour;
        }else{
            $hourString = $hours . self::$hours;
        }

        if ($minutes == 0) {
            $minuteString = '';
        }else if($minutes == 1){
            $minuteString = ' ' . $minutes . self::$minute;
        }else{
            $minuteString = ' ' . $minutes . self::$minutes;
        }

        return $hourString . $minuteString;
    }
}