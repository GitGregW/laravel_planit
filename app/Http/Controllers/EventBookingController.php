<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventBookingController extends Controller
{
    public function show(Event $event) {
        return view('bookings/booking', [
            'event' => $event
        ]);
    }
    
}
