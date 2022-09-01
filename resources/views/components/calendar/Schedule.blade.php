@props(['schedule','i'])
{{-- Wireframe inputs as: 'Monday' | '09 : 00' | '17:00' --}}
{{-- value="{{ old('monday_open')}}" will be out of scope --}}
{{-- custom dates will issue prop as an incremented integer in order to add many --}}

<tr id="row{{ $i }}a" class="schedule__row">
@if (is_numeric($schedule))
    <th class="schedule__table__header"><input type="date" name="opening_times[{{ $i }}][custom_date]" id="opening_times[{{ $i }}][custom_date]"></th>
@else
    @php( $schedule_text = ucwords(str_replace('_',' ',$schedule)) )
    <th class="schedule__table__header">{{ $schedule_text }}
        <input type="text" name="opening_times[{{ $i }}][day]" id="opening_times[{{ $i }}][day]" value="{{ $schedule_text }}" hidden>
    </th>
@endif
    <td><input type="time" name="opening_times[{{ $i }}][opening_time]" id="opening_times[{{ $i }}][opening_time]"></td>
    <td><span class="schedule__info" style="font-family: 'calibri light'">until</span></td>
    <td><input type="time" name="opening_times[{{ $i }}][closing_time]" id="opening_times[{{ $i }}][closing_time]"></td>
</tr>

<tr id="row{{ $i }}b" class="schedule__row">
    @if (!is_numeric($schedule))
        <td id="open_duration{{ $i }}" colspan="4" class="schedule__info--extra"></td>
    @else
    <td id="open_duration{{ $i }}" colspan="2" class="schedule__info--extra"></td>
        <td colspan="2"><input type="checkbox" name="opening_times[{{ $i }}][custom_repeat_yearly]" id="custom_repeat">
            <label for="custom_repeat">Repeat yearly?</label> 
        </td>
    @endif
</tr>

<script>
    document.getElementById("opening_times[{{ $i }}][opening_time]").addEventListener("change", function(){
        openStatus({{ $i }})
    });
    document.getElementById("opening_times[{{ $i }}][closing_time]").addEventListener("change", function(){
        openStatus({{ $i }})
    });
</script>