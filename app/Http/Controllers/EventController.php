<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        
        $event = request()->validate([
            'title' => 'required|min:5|max:80|unique:events,title',
            'body' => 'required|min:10|max:255',
            'address_line_1' => 'required|max:255',
            'address_line_2' => 'required|max:255',
            'address_city' => 'required|max:255',
            'address_county' => 'required|max:255',
            'postcode' => 'required|min:5|max:10',
            'contact_mobile' => 'required|min:6|max:30',
            'contact_landline' => 'required|min:6|max:30'
        ]);
        $event["slug"] = strtolower(str_replace(' ','_', request()->input('title')));
        $event["rating"] = '2.5';

        $id = Event::create($event)->id;

        $event_images = [];
        $event_image_sources = explode(",", request()->input('event_images'));
        foreach($event_image_sources as $key => $source){
            $event_images[$key]['event_id'] = $id;
            $event_images[$key]['src'] = $source;
            list($width, $height) = getimagesize('.' . $source);
            if ($height >= $width) $event_images[$key]['is_portrait'] = '1';
            else $event_images[$key]['is_portrait'] = '0';
        }
        DB::table('event_images')->insert($event_images);

        $event_categories = [];
        foreach (request()->input('event_categories') as $key => $category_id) {
            $event_categories[$key]['event_id'] = $id;
            $event_categories[$key]['category_id'] = $category_id;
        }
        DB::table('event_categories')->insert($event_categories);

        ## Only require Opening Times records where given time inputs are present.
        $event_opening_times = request()->input('event_opening_times');
        $event_opening_times_store = [];
        //dd($event_opening_times);
        foreach($event_opening_times as $key => $event_opening_time){
            if($event_opening_time["opening_time"] && $event_opening_time["closing_time"]){
                $event_opening_times_store[$key] = $event_opening_time;
                $event_opening_times_store[$key]['event_id'] = $id;
            }
        }

        DB::table('event_opening_times')->insert($event_opening_times_store);

        // var_dump(request()->all());
        // $request->session()->flash('success', 'Event has been created.');

        return redirect('/events/'.$event["slug"])->with('success', 'Event has been created.');
    }

    function edit(Event $event) {
        return view('event/' . $event . '/edit', [
            'event' => $event
        ]);
    }

    function update(Event $event){
            //
    }
}
