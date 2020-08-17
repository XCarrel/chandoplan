<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Timeslot;
use App\Activity;

class Slot extends Model
{
    public $timestamps = false;

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
