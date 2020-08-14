<?php

use Illuminate\Database\Seeder;
use App\Domain;

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
    }
}
