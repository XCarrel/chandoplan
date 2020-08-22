<?php


namespace App\Helpers;


use Carbon\Carbon;

class Helpers
{
    /**
     * Returns the day of the week in localized text
     * @param $date
     */
    static function localeDayOfWeek($date)
    {
        $days = ["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"];
        try {
            return $days[Carbon::parse($date)->dayOfWeek];
        } catch (\Exception $e) {
            return "";
        }
    }
}
