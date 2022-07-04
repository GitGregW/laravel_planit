<div class="calendar__label">Mon</div>
<div class="calendar__label">Tue</div>
<div class="calendar__label">Wed</div>
<div class="calendar__label">Thu</div>
<div class="calendar__label">Fri</div>
<div class="calendar__label">Sat</div>
<div class="calendar__label">Sun</div>

@props(['selected_date'])

@php
$num_of_days =  date("t", $selected_date);
$month_start = date("01-m-Y",$selected_date);
$day_of_week =  intval(date("N", strtotime($month_start))); // 1 (for Monday) through 7 (for Sunday)
$fill_day = false;
$day_number = 1;
@endphp
@for ($i = 0; $i < 35; $i++)
@if(!$fill_day && $i+1 === $day_of_week)
    @php($fill_day = true)
@endif
@if($fill_day && $day_number <= date("t", $selected_date))
    <x-calendar.day :day="$day_number" />
    @php($day_number++)
@else
    <x-calendar.day :day=false />
@endif
@endfor

{{-- <div class="calendar__day">
<div class="calendar__date">1</div>
<ul class="calendar__events">
    <!-- logic if event >1 day then alter css to fill -->
    <li class="calendar__events2">Music Festival</li>
    <li class="calendar__events">Classic Car Show</li>
</ul>
</div> --}}