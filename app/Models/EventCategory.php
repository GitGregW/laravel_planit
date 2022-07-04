<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function event()
    {
        return $this->hasMany(Event::class);
    }
    
    public function category()
    {
        return $this->hasMany(Category::class);
    }
}