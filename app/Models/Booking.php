<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = [
        'user_id',
        'assigned_staff_id',
        'activity_id',
        'status',
        'booking_code',
        'started_time',
        'ended_time',
        'user_comment',
        'staff_comment',
        'admin_comment',
        'come_into_office',
        'user_support_file',
        'staff_support_file',
        'admin_support_file',
    ];

    /**
     * Get the user that owns the Booking
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'assigned_staff_id', 'id');
    }

    public function activity()
    {
        return $this->belongsTo(User::class, 'activity_id', 'id');
    }
}
