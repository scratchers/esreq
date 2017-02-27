<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use StudentAffairsUwm\Shibboleth\Entitlement;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'institution_id',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function institution()
    {
        return $this->belongsTo('App\Institution');
    }

    public function esrequests()
    {
        return $this->hasMany('App\Esrequest');
    }

    public function facultyAccounts()
    {
        return $this->hasMany(FacultyAccount::class);
    }

    /**
     * The entitlements that belong to the user.
     */
    public function entitlements()
    {
        return $this->belongsToMany(Entitlement::class);
    }
}
