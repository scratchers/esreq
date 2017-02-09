<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'institution_id',
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
}
