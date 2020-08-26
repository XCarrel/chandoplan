<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Slot;
use App\Timeslot;
use App\User;
use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $timeSlots = Timeslot::all();
        $domains = Domain::all(); // for help display
        // Build a 2d associative array representing the whole plan: row = day, column = timeslot. The array has "holes", ie: some day/slot are undefined
        $slotsArray = [];
        foreach(Timeslot::all() as $ts) {
            foreach($ts->slots as $slot) {
                $slotsArray[$slot->date][$ts->from] = $slot->activities;
            }
        }
        ksort($slotsArray); // because the resulting array is not necesseraly ordered by date. If there is no slot for the first timeslot of the first day, the first day won't be first in the arry
        return view('home')->with(compact('timeSlots','slotsArray','domains'));
    }

    /**
     * Show the big plan: the schedule of every participant through every slot
     */
    public function allSchedules()
    {
        // Build a 2d associative array representing the whole plan: row = person, column = slot. The array has "holes", ie: some person/slot are undefined
        $schedArray = [];
        foreach(User::orderBy('name')->get() as $user) {
            foreach(Slot::orderBy('date')->get() as $slot) {
                $schedArray[$user->name][Helpers::localeDayOfWeek($slot->date)."<br>".Carbon::parse($slot->timeslot->from)->format('H:i')] = $user->subscribedTo($slot);
            }
        }
        return view('allSchedules')->with(compact('schedArray'));
    }
}
