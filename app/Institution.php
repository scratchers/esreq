<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'url',
    ];

    // https://github.com/laravel/framework/issues/1756
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
