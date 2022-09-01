@props(['day','day_label' => '0','today' => '0','event_times' => '0','bookings' => '0','list' => '0'])

<div id="{{ $list ? 'schedule_' : '' }}day{{ $day }}" 
    {{ $attributes->merge(['class' => $event_times ? 'cursor--pointer' : '']) }}
    {{-- If bookng event: create Time Slots form --}}
    {{ $event_times ? 'onclick=checkAvailability(' . $day . ',"' . $event_times['open_time'] . '","' . $event_times['close_time'] . '") 
        onmouseover=scheduleEffectIn(' . $day . ') onmouseout=scheduleEffectOut(' . $day . ')' : '' }}>
    {{-- Display Date --}}
    <div class="calendar__date {{ $today ? 'calendar__date--today' : ''}}">{{ $day_label ? $day_label : $day}}</div>
    {{-- If User booking schedule --}}
    @if ($list)
        <ul id="day_list{{$day}}" class="day__list">
            @if ($bookings)
                @foreach ($bookings as $booking)
                    <li id="day_list_item{{ $booking->id }}" class="day__list__item" onclick="modifyBooking({{'"' . $booking->id . '","' . $booking->title . '","' . $booking->date . ' ' . $booking->time . '"'}})">
                        {{ date("g:ia",strtotime($booking->time)) }} : {{$booking->title}}
                    </li>
                @endforeach
            @endif
        </ul>
    @endif
</div>
{{-- ->merge(['class' => 'calendar__day ']) --}}