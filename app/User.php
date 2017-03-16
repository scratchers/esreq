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

    /**
     * Fix for SQL Server / Linux: https://github.com/laravel/framework/issues/1756#issuecomment-22780611
     */
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

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

    /**
     * Does this user have unfettered access to the system?
     *
     * @return bool
     */
    public function isAdmin() : bool
    {
        $admins = env('SHIBBOLETH_ADMINS');

        if ( empty($admins) ) {
            return false;
        }

        return $this->entitlements->contains('name', $admins);
    }
}
