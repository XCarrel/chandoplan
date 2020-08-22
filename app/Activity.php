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

    public function responsible()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Returns true if $user has subscribed to the activity
     * @param $user
     * @return bool
     */
    public function hasUser($user)
    {
        return ($this->users()->where('users.id',$user->id)->count() > 0) || ($this->responsible->id == $user->id);
    }
}
