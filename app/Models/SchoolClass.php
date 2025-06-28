<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_name',
    ];


    public function students()
    {
        return $this->hasMany(Student::class, 'school_class_id');
    }

    // public function walikelas()
    // {
    //     return $this->belongsTo(Guru::class, 'homeroom_teacher');
    // }
}
