@props(['selected_date','days','event_bookings' => '0'])

@php
    if($selected_date == strtotime(date("M-Y"))) $today = date("j");
    elseif($selected_date < strtotime(date("M-Y"))) $today = 32;
    else $today = 0;
@endphp

<div id="user_schedule" class="user__schedule">
    <h3 class="user__schedule__header">My Planner</h3>
    <table class="user__schedule__table">
        @for ($i = 1; $i <= $days; $i++)
            <tr>
            @if (!$today && isset($event_bookings))
                @php
                    foreach($event_bookings as $event_booking){
                        $day = date('j', strtotime($event_booking["date"]));
                        $bookings[$day] = $event_booking;
                    }
                @endphp
                <x-schedule.day :days="$days" :bookings="$bookings"></x-schedule.day>
            @else
                <x-schedule.day :days="$days"></x-schedule.day>
            @endif
            </tr>
        @endfor
    </table>
</div>