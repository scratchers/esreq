<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Esrequest extends Model
{
    protected $fillable = [
        'course_name',
        'faculty_accounts',
        'student_accounts',
        'date_begin',
        'date_end',
        'IBM',
        'Microsoft',
        'SAP',
        'SAS',
        'Teradata',
    ];

    public function fields()
    {
        return array_merge($this->fillable, ['created_at','fulfilled_at']);
    }
}
