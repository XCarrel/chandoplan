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
        Carbon::setLocale(config('app.locale'));
        try {
            return Carbon::parse($date)->localeDayOfWeek;
        } catch (\Exception $e) {
            return "";
        }
    }
}
