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
     * Tells if this user is free (=has no activity planned) for a given slot
     * @param Slot $slot
     */
    public function isFree(Slot $slot)
    {
        $nbact = $this->activities()->whereHas('slot', function ($s) use ($slot) {
            $s->where('id', $slot->id);
        })->count();
        $nbresp = $this->responsibilities()->whereHas('slot', function ($s) use ($slot) {
            $s->where('id', $slot->id);
        })->count();
        return ($nbact == 0 && $nbresp == 0);
    }
}
