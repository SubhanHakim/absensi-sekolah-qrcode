<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'student_id',
        'user_id',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    
}
