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
        return $this->belongsTo(Timeslot::class)->orderBy('from');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
