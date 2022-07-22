@props(['day_i','date','open','close'])

<div id="day{{ $day_i }}" 
    {{ $attributes->merge(['class' => 'calendar__day ']) }}
    {{ $date ? 'onclick=checkAvailability(' . $day_i . ',"' . $date . '","' . $open . '","' . $close . '")' : '' }}>
    <div class="calendar__date">{{ $day_i }}</div>
    <div class="calendar__events">
        <ul class="calendar__day__list" id="calendar_day_items{{ $day_i }}"></ul>
    </div>
</div>
{{-- @else
    <div class="calendar__day {{ $day_i ? '' : 'day--blank' }}"></div>
@endif --}}

{{-- Append a list item on day[x] <ul> that contains event name. To include form element. --}}
{{-- *Responsive design: as per IOS iPhone calendar
        OR
            Design to fit landscape iPhone Mini resolution --}}