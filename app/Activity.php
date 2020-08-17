<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Domain;
use App\Slot;

class Activity extends Model
{
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
