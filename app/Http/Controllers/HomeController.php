<?php

namespace App\Http\Controllers;

use App\Slot;
use App\Timeslot;
use App\User;
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
        // Build a 2d associative array representing the whole plan: row = day, column = timeslot. The array has "holes", ie: some day/slot are undefined
        $slotsArray = [];
        foreach(Timeslot::all() as $ts) {
            foreach($ts->slots as $slot) {
                $slotsArray[$slot->date][$ts->from] = $slot->activities;
            }
        }
        ksort($slotsArray); // because the resulting array is not necesseraly ordered by date. If there is no slot for the first timeslot of the first day, the first day won't be first in the arry
        return view('home')->with(compact('timeSlots','slotsArray'));
    }
}
