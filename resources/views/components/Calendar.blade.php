@props(['selected_date','event'])

@php
// dd($event['event_opening_times'][1]['day']);
$day_labels = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
$days =  date("t", $selected_date);
$month_start = date("01-M-Y",$selected_date);
$day_start =  intval(date("N", strtotime($month_start))); // 1 (for Monday) through 7 (for Sunday)
$day_i = 1;
$calendar_rows = ceil(($days + ($day_start - 1)) / 7);
$blank_ends = ($calendar_rows * 7) - ($days + $day_start);

foreach($event->event_opening_times as $opening_time){
    ## Make days_open as "[0] => 'Friday'" ## REVIEW changing to id only.
    $day_key = array_search($opening_time->day, $day_labels);
    for ($i=0; $i < $calendar_rows; $i++) {
        $keys[] = ($day_key + ($i * 7)) - ($day_start - 1);
        $opening_days[] = $opening_time->id;
        $open_time[] = $opening_time->opening_time;
        $close_time[] = $opening_time->closing_time;
    }
    $days_open = array_combine($keys, $opening_days);
    $times_open = array_combine($keys, $open_time);
    $times_close = array_combine($keys, $close_time);
}

@endphp

@foreach ($day_labels as $day_label)
    <div class="calendar__label">{{ $day_label }}</div>
@endforeach

@for ($i = 1; $i < $day_start; $i++)
    <x-calendar.day :day_i=false :date=false class="day--blank" />
@endfor

@for ($i = 0; $i < $days; $i++)
    @if (array_key_exists($i, $days_open))
    <x-calendar.day :day_i="$day_i" :date="date('Y-m-').$day_i" :open="$times_open[$i]" :close="$times_close[$i]" class="calendar__day--active" />
    {{-- :date="$days_open[$i]" --}}
    @else
    <x-calendar.day :day_i="$day_i" :date=false class="day--blank" />
    @endif
    @php($day_i++)
@endfor

@for ($i = 0; $i <= $blank_ends; $i++)
    <x-calendar.day :day_i=false :date=false class="day--blank" />
@endfor


{{-- <div class="calendar__day">
<div class="calendar__date">1</div>
<ul class="calendar__events">
    <!-- logic if event >1 day then alter css to fill -->
    <li class="calendar__events2">Music Festival</li>
    <li class="calendar__events">Classic Car Show</li>
</ul>
</div> --}}