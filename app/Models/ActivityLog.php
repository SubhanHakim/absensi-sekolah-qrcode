<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'user_id',
        'user_name',
        'user_role',
    ];

    /**
     * Get the user that performed the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include recent activities.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('created_at', 'desc')
                    ->limit($limit);
    }

    /**
     * Get formatted created time.
     *
     * @return string
     */
    public function getFormattedTimeAttribute()
    {
        $created = $this->created_at;
        
        if ($created->isToday()) {
            return $created->format('H:i');
        }
        
        return $created->format('H:i - d/m/Y');
    }
}