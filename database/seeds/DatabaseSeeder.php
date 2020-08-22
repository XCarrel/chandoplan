<?php

use Illuminate\Database\Seeder;
use App\Domain;
use App\Slot;
use App\Timeslot;
use App\Activity;
use App\User;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $me = new User();
        $me->name = "Xavier";
        $me->email = "xavier.carrel@cpnv.ch";
        $me->password = password_hash('Pa$$w0rd',PASSWORD_BCRYPT);
        $me->level = 1;
        $me->save();

        Domain::create(['name' => 'Cuisine', 'slug' => 'kitchen']);
        Domain::create(['name' => 'Ravitaillement', 'slug' => 'supply']);
        Domain::create(['name' => 'Service', 'slug' => 'service']);
        Domain::create(['name' => 'ICT-120', 'slug' => 'job120']);
        Domain::create(['name' => 'ICT-404', 'slug' => 'job404']);
        Domain::create(['name' => 'ProjetWebBDD', 'slug' => 'jobpweb']);
        Domain::create(['name' => 'ICT-226', 'slug' => 'job226']);
        Domain::create(['name' => 'Soirée', 'slug' => 'evening']);
        Domain::create(['name' => 'Extérieure', 'slug' => 'outdoor']);

        Timeslot::create(['from' => '07:00', 'to' => '08:00', 'mandatory' => 0]); // Service
        Timeslot::create(['from' => '08:00', 'to' => '09:30', 'mandatory' => 0]); // Cours / Activités
        Timeslot::create(['from' => '10:00', 'to' => '11:30', 'mandatory' => 0]); // Cours / Activités
        Timeslot::create(['from' => '11:30', 'to' => '12:15', 'mandatory' => 0]); // Service+Cuisine
        Timeslot::create(['from' => '13:30', 'to' => '15:00', 'mandatory' => 0]); // Cours / Activités
        Timeslot::create(['from' => '17:00', 'to' => '19:00', 'mandatory' => 0]); // Service+Cuisine
        Timeslot::create(['from' => '19:00', 'to' => '20:00', 'mandatory' => 0]); // Service
        Timeslot::create(['from' => '20:30', 'to' => '23:00', 'mandatory' => 0]); // Social

        // Arrival day
        foreach (Timeslot::where('from','>=','17:00')->get() as $ts) {
            $newslot = new Slot();
            $newslot->date = Carbon::create(2020,9,21);
            $newslot->timeslot()->associate($ts);
            $newslot->save();
        }

        // Full days
        foreach (Timeslot::all() as $ts) {
            $date = Carbon::create(2020,9,21);
            for ($i = 0; $i < 3; $i++) {
                $newslot = new Slot();
                $newslot->date = $date->addDays(1);
                $newslot->timeslot()->associate($ts);
                $newslot->save();
            }
        }

        // Departure day
        foreach (Timeslot::where('to','<=','08:00')->get() as $ts) {
            $newslot = new Slot();
            $newslot->date = Carbon::create(2020,9,25);
            $newslot->timeslot()->associate($ts);
            $newslot->save();
        }

        // Kitchen activities
        $cook = Domain::where('name','Cuisine')->first();
        $serve = Domain::where('name','Service')->first();
        $supply = Domain::where('name','Ravitaillement')->first();

        // Petit déjeuner
        foreach (Slot::whereHas('timeslot', function($q){ $q->where('from', '07:00'); })->get() as $slot) {
            Activity::create([
                "description" => "Service petit déj",
                "location" => "Cuisine",
                "minparticipants" => 6,
                "maxparticipants" => 6,
                "domain_id" => $serve->id,
                "slot_id" => $slot->id,
                "user_id" => $me->id
            ]);
        }
        foreach (Slot::whereHas('timeslot', function($q){ $q->where('from', '08:00'); })->get() as $slot) {
            Activity::create([
                "description" => "Rangements & Ravitaillement",
                "location" => "Cuisine",
                "minparticipants" => 2,
                "maxparticipants" => 2,
                "domain_id" => $supply->id,
                "slot_id" => $slot->id,
                "user_id" => $me->id
            ]);
        }
        // Midi
        foreach (Slot::whereHas('timeslot', function($q){ $q->where('from', '11:30'); })->get() as $slot) {
            Activity::create([
                "description" => "Préparation lunch",
                "location" => "Cuisine",
                "minparticipants" => 2,
                "maxparticipants" => 2,
                "domain_id" => $cook->id,
                "slot_id" => $slot->id,
                "user_id" => $me->id
            ]);
            Activity::create([
                "description" => "Service lunch",
                "location" => "Cuisine",
                "minparticipants" => 6,
                "maxparticipants" => 6,
                "domain_id" => $serve->id,
                "slot_id" => $slot->id,
                "user_id" => $me->id
            ]);
        }
        foreach (Slot::whereHas('timeslot', function($q){ $q->where('from', '13:30'); })->get() as $slot) {
            Activity::create([
                "description" => "Rangements & Ravitaillement",
                "location" => "Cuisine",
                "minparticipants" => 2,
                "maxparticipants" => 2,
                "domain_id" => $supply->id,
                "slot_id" => $slot->id,
                "user_id" => $me->id
            ]);
        }
        // Soir
        foreach (Slot::whereHas('timeslot', function($q){ $q->where('from', '17:00'); })->get() as $slot) {
            Activity::create([
                "description" => "Cuisiner",
                "location" => "Cuisine",
                "minparticipants" => 6,
                "maxparticipants" => 6,
                "domain_id" => $cook->id,
                "slot_id" => $slot->id,
                "user_id" => $me->id
            ]);
            Activity::create([
                "description" => "Servir",
                "location" => "Cuisine",
                "minparticipants" => 6,
                "maxparticipants" => 6,
                "domain_id" => $serve->id,
                "slot_id" => $slot->id,
                "user_id" => $me->id
            ]);
        }
        foreach (Slot::whereHas('timeslot', function($q){ $q->where('from', '19:00'); })->get() as $slot) {
            Activity::create([
                "description" => "Rangements",
                "location" => "Cuisine",
                "minparticipants" => 2,
                "maxparticipants" => 2,
                "domain_id" => $supply->id,
                "slot_id" => $slot->id,
                "user_id" => $me->id
            ]);
        }

    }
}
