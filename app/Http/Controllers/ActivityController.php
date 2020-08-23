<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Domain;
use App\Slot;
use App\Timeslot;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $act = new Activity();
        $domains = Domain::all();
        $slots = Slot::distinct()->get(['date']);
        $timeslots = Timeslot::all();
        $users = User::all();
        return view('activities.create')->with(compact('act', 'domains', 'slots', 'timeslots','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // find the selected slot
        $slot = Slot::where('date', $request->input('day'))->where('timeslot_id', $request->input('timeslot'))->first();
        if ($slot == null) { // create new slot
            $slot = new Slot();
            $slot->date = $request->input('day');
            $slot->timeslot_id = $request->input('timeslot');
            $slot->save();
        }
        $newact = new Activity();
        $newact->title = $request->input('title');
        $newact->description = $request->input('description');
        $newact->location = $request->input('location');
        $newact->minparticipants = $request->input('minp');
        $newact->maxparticipants = $request->input('maxp');
        $newact->domain_id = $request->input('domain');
        $newact->user_id = $request->input('resp');
        $newact->slot_id = $slot->id;
        try {
            $newact->save();
            return redirect('home')->with(['status' => 'Activité créée']);
        } catch (\Exception $e) {
            return redirect('home')->with(['status' => "Erreur: l'activité n'a pas pu être enregistrée"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $act = Activity::find($id);
        return view('activities.show')->with(compact('act'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $act = Activity::find($id);
        if (Auth::user()->level < 1 && Auth::user()->id != $act->responsible->id) return (redirect('home'))->with(['status' => 'Petit malin ...']);
        $domains = Domain::all();
        $slots = Slot::distinct()->get(['date']);
        $timeslots = Timeslot::all();
        $users = User::all();
        return view('activities.edit')->with(compact('act', 'domains', 'slots', 'timeslots','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $act = Activity::find($id);
        if (Auth::user()->level < 1 && Auth::user()->id != $act->responsible->id) return (redirect('home'))->with(['status' => 'Petit malin ...']);
        // find the selected slot
        $slot = Slot::where('date', $request->input('day'))->where('timeslot_id', $request->input('timeslot'))->first();
        if ($slot == null) { // create new slot
            $slot = new Slot();
            $slot->date = $request->input('day');
            $slot->timeslot_id = $request->input('timeslot');
            $slot->save();
        }
        $act->title = $request->input('title');
        $act->description = $request->input('description');
        $act->location = $request->input('location');
        $act->minparticipants = $request->input('minp');
        $act->maxparticipants = $request->input('maxp');
        $act->domain_id = $request->input('domain');
        $act->user_id = $request->input('resp');
        $act->slot_id = $slot->id;
        try {
            $act->save();
            return redirect('home')->with(['status' => 'Activité modifiée']);
        } catch (\Exception $e) {
            return redirect('home')->with(['status' => "Erreur: les modifications n'ont pas pu être enregistrées"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $act = Activity::find($id);
        if (Auth::user()->level < 1 && Auth::user()->id != $act->responsible->id) return (redirect('home'))->with(['status' => 'Petit malin ...']);
        $act->delete();
        return redirect('home')->with(['status' => 'Suppression OK']);
    }

    public function subscribe(Request $request, $id)
    {
        $act = Activity::find($id);
        $act->users()->attach(Auth::user()->id);
        return redirect('home')->with(['status' => 'Inscription enregistrée']);
    }

    public function unsubscribe(Request $request, $id)
    {
        $act = Activity::find($id);
        $act->users()->detach(Auth::user()->id);
        return redirect('home')->with(['status' => 'Désinscription enregistrée']);
    }
}
