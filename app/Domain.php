<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Activity;

class Domain extends Model
{
    public $timestamps = false;

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
