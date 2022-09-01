<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventBookingController extends Controller
{
    public function show(Event $event, $selected_date = null) {
        if(!$selected_date){
            $selected_date = date("M-Y");
        }
        $start_date = date("Y-m-d", strtotime($selected_date));
        $end_date = date("Y-m-t", strtotime($selected_date));
        if(auth()->user()){
            return view('bookings/booking', [
                'event' => $event,
                'selected_date' => $selected_date,
                'event_bookings' => EventBooking::join('events', 'event_bookings.event_id', '=', 'events.id')
                    ->where([
                        ['event_bookings.user_id', '=', auth()->user()->id],
                        ['date', '>=', $start_date],
                        ['date', '<=', $end_date]
                        ])
                    ->select('event_bookings.*','events.title')
                    ->get()
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
        if(auth()->user()){
            $datetime = explode(" ",request()->input('day_slots'));
            $booking["event_id"] = $event_id;
            $booking["user_id"] = auth()->user()->id;
            $booking["date"] = date("Y-m-d", strtotime($datetime[0]));
            $booking["time"] = $datetime[1];

            EventBooking::create($booking);
            return redirect('/bookings/'.$booking["user_id"].'/review')->with('success', 'Booking has been placed.');
        }
        else return redirect('/login');
    }
    
    public function edit($user_id = null, $selected_date = null) {
        if(!$selected_date){
            $selected_date = date("M-Y");
        }
        $start_date = date("Y-m-d", strtotime($selected_date));
        $end_date = date("Y-m-t", strtotime($selected_date));
        if(auth()->user() && auth()->user()->id == $user_id){
            return view('bookings/plans', [
                'selected_date' => $selected_date,
                'event_bookings' => EventBooking::join('events', 'event_bookings.event_id', '=', 'events.id')
                    ->where([
                        ['event_bookings.user_id', '=', auth()->user()->id],
                        ['date', '>=', $start_date],
                        ['date', '<=', $end_date]
                        ])
                    ->select('event_bookings.*','events.title')
                    ->get()
            ]);
        }
        else{
            // return view('bookings/plans', [
            //     'selected_date' => $selected_date
            // ]);
            return redirect('/login');
        }
    }

    public function destroy($id){
        // AJAX / JSON response to cancel a users scheduled event
        if(auth()->user()){
            $booking = EventBooking::find($id);
            if($booking->user_id == auth()->user()->id){
                $booking->delete($id);
                $msg = $booking->title . " has been cancelled.";
            }
            else return redirect('/bookings/'.$booking["user_id"].'/review')->with('success', 'Failed to validate your cancellation request.');
        }
        else return redirect('/bookings/'.$booking["user_id"].'/review')->with('success', 'Session expired. Please log in.');

        return response()->json(['msg' => $msg]);
    }
}
