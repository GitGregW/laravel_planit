<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventBookingController extends Controller
{
    public function show(Event $event, $selected_date = null) {
        if(!$selected_date){
            $selected_date = date("M-Y");
        }
        if(auth()->user()){
            return view('bookings/booking', [
                'event' => $event,
                'selected_date' => $selected_date,
                'event_bookings' => EventBooking::where('user_id', auth()->user()->id)->get()
            ]);
        }
        else{
            return view('bookings/booking', [
                'event' => $event,
                'selected_date' => $selected_date
            ]);
        }
    }

    public function store($event_id = null){
        // $booking = request()->validate([
        //     'day_slots',
        //     // 'price',
        //     // 'discount'
        // ]);
        $booking["event_id"] = $event_id;
        $booking["user_id"] = 1;
        $booking["date"] = request()->input('day_slots');

        EventBooking::create($booking);
        return redirect('/plans')->with('success', 'Booking has been placed.');
    }
    
}
