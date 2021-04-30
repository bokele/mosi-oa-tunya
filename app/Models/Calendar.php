<?php

namespace App\Models;

use App\Jobs\SynchronizeGoogleEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calendar extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'color', 'timezone'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
