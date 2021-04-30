<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'staff_id', 'status_id', 'activity_code', 'name', 'description', 'started_at',
        'ended_at',
        'support_activite_file',
    ];

    public function staff()
    {
        $this->belongsTo(User::class, 'staff_id', 'id');
    }
    // protected function serializeDate(\DateTimeInterface $date)
    // {
    //     return $date->format('d-m-Y H:i:s');
    // }
}
