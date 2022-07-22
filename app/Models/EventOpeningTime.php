<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventOpeningTime extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Event()//: BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
