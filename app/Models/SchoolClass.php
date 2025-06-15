<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = [
        'class_name',
        'homeroom_teacher'
    ];


    public function students()
    {
        return $this->hasMany(Student::class, 'school_class_id');
    }

    public function walikelas()
    {
        return $this->belongsTo(Guru::class, 'homeroom_teacher');
    }
}
