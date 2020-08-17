<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Slot;

class Timeslot extends Model
{
    public $timestamps = false;

    public function slots()
    {
        return $this->hasMany(Slot::class)->orderBy('date');
    }
}
