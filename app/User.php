<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Activity;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function responsibilities()
    {
        return $this->hasMany(Activity::class, 'user_id');
    }

    /**
     * Tells what activity a user has subscribed to for the given slot, null if none
     * @param Slot $slot
     */
    public function subscribedTo(Slot $slot)
    {
        $act = $this->activities()->whereHas('slot', function ($s) use ($slot) {
            $s->where('id', $slot->id);
        })->first();
        if ($act) return $act;
        $resp = $this->responsibilities()->whereHas('slot', function ($s) use ($slot) {
            $s->where('id', $slot->id);
        })->first();
        return ($resp);
    }
}
