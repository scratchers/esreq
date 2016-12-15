<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Esrequest extends Model
{
    public static $platforms = [
        'IBM',
        'Microsoft',
        'SAP',
        'SAS',
        'Teradata',
    ];

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

    protected $dates = [
        'date_begin',
        'date_end',
        'fulfilled_at',
        'cancelled_at',
    ];

    // https://github.com/laravel/framework/issues/1756
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function fields()
    {
        return array_merge($this->fillable, ['created_at','fulfilled_at']);
    }

    public function setFacultyAccountsAttribute($value) {
        $this->attributes['faculty_accounts'] = empty($value)?0:$value;
    }

    public function setStudentAccountsAttribute($value) {
        $this->attributes['student_accounts'] = empty($value)?0:$value;
    }

    public function setCourseNameAttribute($value) {
        $this->attributes['course_name'] = empty($value)?null:$value;
    }

    public function setDateBeginAttribute($value) {
        $this->attributes['date_begin'] = empty($value)?null:$value;
    }

    public function setDateEndAttribute($value) {
        $this->attributes['date_end'] = empty($value)?null:$value;
    }
}
