<?php

use Illuminate\Database\Seeder;
use App\Domain;
use App\Slot;
use App\Timeslot;
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
        Domain::create(['name' => 'Cuisine']);
        Domain::create(['name' => 'Ravitaillement']);
        Domain::create(['name' => 'Service']);
        Domain::create(['name' => 'ICT-120']);
        Domain::create(['name' => 'ICT-404']);
        Domain::create(['name' => 'ProjetWebBDD']);
        Domain::create(['name' => 'ICT-226']);
        Domain::create(['name' => 'Soirée']);
        Domain::create(['name' => 'Extérieure']);

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
            $basedate = Carbon::create(2020,9,22);
            for ($i = 0; $i < 3; $i++) {
                $newslot = new Slot();
                $newslot->date = $basedate->addDays($i);
                $newslot->timeslot()->associate($ts);
                $newslot->save();
            }
        }

        // Departure day
        foreach (Timeslot::where('to','<=','08:00')->get() as $ts) {
            $newslot = new Slot();
            $newslot->date = Carbon::create(2020,9,21);
            $newslot->timeslot()->associate($ts);
            $newslot->save();
        }

    }
}
