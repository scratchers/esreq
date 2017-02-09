<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    /**
     * The faculty accounts with access to this platform.
     */
    public function facultyAccounts()
    {
        return $this->belongsToMany(FacultyAccount::class);
    }
}
