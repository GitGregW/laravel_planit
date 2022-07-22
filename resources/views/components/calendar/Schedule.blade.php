@props(['schedule','i'])
{{-- Wireframe inputs as: 'Monday' | '09 : 00' | '17:00' --}}
{{-- value="{{ old('monday_open')}}" will be out of scope --}}
{{-- custom dates will issue prop as an incremented integer in order to add many --}}

<tr>
@if (is_numeric($schedule))
    <th><input type="date" name="event_opening_times[{{ $i }}][custom_date]" id="event_opening_times[{{ $i }}][custom_date]"></th>
@else
    @php( $schedule_text = ucwords(str_replace('_',' ',$schedule)) )
    <th>{{ $schedule_text }}</th>
    <th><input type="text" name="event_opening_times[{{ $i }}][day]" id="event_opening_times[{{ $i }}][day]" value="{{ $schedule_text }}" hidden></th>
@endif
    <td><span id="open_status{{ $i }}" style="color:lightgrey">Closed</span></td>
    <td>
        <input type="time" name="event_opening_times[{{ $i }}][opening_time]" id="event_opening_times[{{ $i }}][opening_time]">
        <span id="" style="min-width: 3em; font-family: 'calibri light'"> to </span>
        <input type="time" name="event_opening_times[{{ $i }}][closing_time]" id="event_opening_times[{{ $i }}][closing_time]">
        <span id="open_duration{{ $i }}" style="font-family: 'calibri light'"></span>
    </td>
@if (is_numeric($schedule))
    <td colspan="3"><input type="checkbox" name="event_opening_times[{{ $i }}][custom_repeat_yearly]" id="custom_repeat">
        <label for="custom_repeat">Repeat yearly?</label> 
    </td>
@endif
</tr>

<script>
    document.getElementById("event_opening_times[{{ $i }}][opening_time]").addEventListener("change", function(){
        openStatus(document.getElementById("event_opening_times[{{ $i }}][opening_time]"), document.getElementById("event_opening_times[{{ $i }}][closing_time]"), document.getElementById("open_status{{ $i }}"), document.getElementById("open_duration{{ $i }}"))
    });
    document.getElementById("event_opening_times[{{ $i }}][closing_time]").addEventListener("change", function(){
        openStatus(document.getElementById("event_opening_times[{{ $i }}][opening_time]"), document.getElementById("event_opening_times[{{ $i }}][closing_time]"), document.getElementById("open_status{{ $i }}"), document.getElementById("open_duration{{ $i }}"))
    });
</script>