<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Esrequest extends Model
{
    public static function platforms()
    {
        return [
            'IBM',
            'Microsoft',
            'SAP',
//             'SAS',
            'Teradata',
        ];
    }

    public static function courseInfo()
    {
        return [
            'course_name',
            'date_begin',
            'date_end',
        ];
    }

    public static function accounts()
    {
        return [
            'faculty_accounts',
            'student_accounts',
        ];
    }

    public static function metadata()
    {
        return [
            'created_at',
            'updated_at',
            'fulfilled_at',
            'cancelled_at',
        ];
    }

    protected $fillable = [
        'IBM',
        'Microsoft',
        'SAP',
        'SAS',
        'Teradata',
        'faculty_accounts',
        'student_accounts',
        'course_name',
        'date_begin',
        'date_end',
        'user_comment',
    ];

    protected $dates = [
        'date_begin',
        'date_end',
        'created_at',
        'updated_at',
        'fulfilled_at',
        'cancelled_at',
    ];

    // https://github.com/laravel/framework/issues/1756
    protected function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function getPlatforms(Bool $string = false)
    {
        $platforms = [];
        foreach(static::platforms() as $platform){
            if(!empty($this->$platform)){
                $platforms []= $platform;
            }
        }
        if($string){
            return implode(', ',$platforms);
        }
        return $platforms;
    }

    public function getAllValuesFor(String ...$static_methods)
    {
        foreach($static_methods as $static_method){
            foreach(static::$static_method() as $field){
                $info[$field] = $this->$field ?? null;
            }
        }
        return $info ?? [];
    }

    public function getValuesFor(String ...$static_methods)
    {
        foreach($static_methods as $static_method){
            foreach(static::$static_method() as $field){
                if(!empty($this->$field)){
                    $info[$field] = $this->$field;
                }
            }
        }
        return $info ?? [];
    }

    public function getFields()
    {
        return array_merge(
            ['platforms' => $this->getPlatforms(true)],
            $this->getAllValuesFor('accounts', 'metadata'),
            $this->getValuesFor('courseInfo')
        );
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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function userBriefs() : string
    {
        $user = $this->user()->first();

        $institution = $user->institution()->first();

        return "{$user->first_name} {$user->last_name}, {$institution->name}";
    }
}
