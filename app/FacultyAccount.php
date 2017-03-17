<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class FacultyAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
    ];

    /**
     * The user that owns the faculty account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The platforms on which this account is active.
     */
    public function platforms()
    {
        return $this->belongsToMany(Platform::class);
    }

    /**
     * Scope query to only user's faculty accounts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMine($query)
    {
        return $query
            ->where('faculty_accounts.user_id', '=', Auth::user()->id)
        ;
    }
}
