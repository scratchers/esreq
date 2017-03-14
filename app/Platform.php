<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The faculty accounts with access to this platform.
     */
    public function facultyAccounts()
    {
        return $this->belongsToMany(FacultyAccount::class);
    }

    /**
     * The requests for this platforms.
     */
    public function esrequests()
    {
        return $this->belongsToMany(Esrequest::class);
    }
}
