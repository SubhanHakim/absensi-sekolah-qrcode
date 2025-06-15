<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'nama',
        'nip',
        'email',
        'mapel',
        'user_id',
        'school_class_id',
    ];

    public function kelaswali()
    {
        return $this->hasOne(SchoolClass::class, 'homeroom_teacher');
    }
    public function kelas()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
}
