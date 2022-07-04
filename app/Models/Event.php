<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['event_image', 'event_category'];
    
    // protected function slug(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn ($value, $attributes) => strtolower(str_replace(' ','-',$attributes['title'])),
    //     );
    // }

    public function event_image()
    {
        return $this->hasMany(EventImage::class);
    }

    public function event_category()
    {
        return $this->hasMany(EventCategory::class);
    }

    public function event_booking()
    {
        return $this->hasMany(EventBooking::class);
    }
}

