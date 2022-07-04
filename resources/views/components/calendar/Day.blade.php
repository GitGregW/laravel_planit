@props(['day'])

<div class="calendar__day {{ $day ? '' : 'day--blank' }}">
    <div class="calendar__date">{{ $day }}</div>
    <div class="calendar__events">
        @if($day)
            An Event.
        @endif
    </div>
</div>