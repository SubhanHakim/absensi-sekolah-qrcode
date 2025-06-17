<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($description)
    {
        $user = Auth::user();
        
        return ActivityLog::create([
            'description' => $description,
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : 'System',
            'user_role' => $user ? $user->role : null,
        ]);
    }
}