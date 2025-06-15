<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'user_id',
        'school_class_id',
        'nis',
        'qr_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    public function kelas()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
    public function parent()
{
    return $this->hasOne(Parents::class, 'student_id');
}
}
