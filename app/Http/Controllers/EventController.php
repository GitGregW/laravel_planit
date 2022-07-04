<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index() {
        return view('events/events', [
            'events' => Event::all()
        ]);
    }

    public function show(Event $event) {
        return view('events/event', [
            'event' => $event
        ]);
    }

    public function create() {
        return view('events/create');
    }

    public function store() {
        $event->event_image_id = '1';
        $event->event_category_id = '1';
        $event->rating = '2.5';

        $event = request()->validate([
            // 'image_id' => '',
            'event_category_id' => 'required|exist:event_categories,id',
            'slug' => 'required',
            'title' => 'required|min:5|max:80|unique:events,title',
            'body' => 'required|min:10|max:255',
            'Address_line_1' => 'required|max:255',
            'Address_line_2' => 'required|max:255',
            'Address_city' => 'required|max:255',
            'Address_county' => 'required|max:255',
            'postcode' => 'required|min:5|max:10',
            'contact_mobile' => 'required|min:6|max:30',
            'contact_landline' => 'required|min:6|max:30',
            // 'rating' => ''
        ]);

        // foreach($event->)
        
        // var_dump(request()->all());

        Event::create($event); //$event->save(); //replace with based on object assigning
        
        // EventImage::create($someotherevent);

        // $request->session()->flash('success', 'Event has been created.');

        return redirect('/events/'.$event->slug)->with('success', 'Event has been created.');
    }

    // function show(Event $event) {
    //     return view('event', [
    //         'event' => $event
    //     ]);
    // }
}
