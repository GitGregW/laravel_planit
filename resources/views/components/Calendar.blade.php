@props(['selected_date','event_times' => '0','bookings' => '0', 'list' => '0'])

@php
$day_labels = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
$days =  date("t", $selected_date); // total number of days for the month
$month_start = date("01-M-Y",$selected_date);
$day_start =  intval(date("N", strtotime($month_start))); // 1 (for Monday) through 7 (for Sunday)
$day = 1;
$calendar_rows = ceil(($days + ($day_start - 1)) / 7);
$blank_ends = ($calendar_rows * 7) - ($days + $day_start);

// Where today is true; readonly/grey-out the day. today is today; highlight & today is false; make day editible.
if($selected_date == strtotime(date("M-Y"))) $today = date("j");
elseif($selected_date < strtotime(date("M-Y"))) $today = 32;
else $today = 0;

@endphp

<div id="calendar" {{ $attributes }}>
    {{-- Calendar labels: Monday, Tuesday, Wednesday ... --}}
    @foreach ($day_labels as $day_label)
        <div class="calendar__label {{ $list ? '--hidden' : ''}}">{{ $day_label }}</div>
    @endforeach
    
    {{-- Calendar blanks start --}}
    @for ($i = 1; $i < $day_start; $i++)
        <x-calendar.day :day=false class="day--blank {{ $list ? '--hidden' : ''}}" />
    @endfor
    
    @for ($i = 0; $i < $days; $i++)

    @endfor

    {{-- Event Schedule Calendar days --}}
    @if ($event_times)
        @for ($i = 0; $i < $days; $i++)
            @if (!$today && isset($event_times[$i]))
                <x-calendar.day :day="$day" :date="date('Y-m-').$day" :event_times="$event_times[$i]"
                    class="calendar__day calendar__day--grid calendar__day--active" />
            @elseif ($today == $i + 1)
                @if (isset($event_times[$i]))
                {{-- Where date is today; allow bookable slots +1 hour from now until close. --}}
                    @php
                    $last_time_slot = date('H:00:00', strtotime('2 hour'));
                    if($last_time_slot < $event_times[$i]["close_time"] && $last_time_slot > $event_times[$i]["open_time"]) $event_times[$i]["open_time"] = $last_time_slot;
                    @endphp
                    <x-calendar.day :day="$day" :event_times="$event_times[$i]"
                        today="1" class="calendar__day calendar__day--grid calendar__day--active" />
                @else
                    <x-calendar.day :day="$day"
                        today="1" class="calendar__day calendar__day--grid calendar__day--active day--blank" />
                @endif
                @php($today = 0)
            @else
                <x-calendar.day :day="$day" class="calendar__day calendar__day--grid day--blank" />
            @endif
            @php($day++)
        @endfor
    @else
    {{-- User Schedule Calendar days --}}
        @for ($i = 0; $i < $days; $i++)
            @php($day_label = date("D jS F", strtotime(date("$day-M-Y",$selected_date))))
            @if (isset($bookings[$i]))
                <x-calendar.day :day="$day" :day_label="$day_label" :bookings="$bookings[$i]" list="1"
                    class="calendar__day calendar__day--active {{ $list ? 'calendar__day--list' : 'calendar__day--grid'}}" />
            @else
                <x-calendar.day :day="$day" :day_label="$day_label" list="1"
                    class="calendar__day calendar__day--active {{ $list ? 'calendar__day--list' : 'calendar__day--grid'}}" />
            @endif
            @php($day++)
        @endfor
    @endif
    
    {{-- Calendar blanks end --}}
    @for ($i = 0; $i <= $blank_ends; $i++)
        <x-calendar.day :day=false class="day--blank {{ $list ? '--hidden' : ''}}" />
    @endfor
</div>

<!-- The Modal : For Bookings -->
<div id="booking_edit_modal" class="modal">
    <div id="modal_content" class="modal__content">
        <span class="close">&times;</span>
        <p id="booking_edit_modal_text"></p>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function scheduleEffectIn(day){
        // Scroll to User Schedule Day. Add border styling.
        let userList = document.getElementById("user_schedule");
        let listBlock = document.getElementById("schedule_day" + day);
        let listScrollTo = listBlock.offsetTop - document.getElementById("schedule_day1").offsetTop;
        userList.scrollTop = listScrollTo - 75;
        listBlock.style.border = 'solid yellow';
        listBlock.style.borderRadius = '2px';
    }
    function scheduleEffectOut(day){
        // Remove inline styling.
        document.getElementById("schedule_day" + day).style = "none";
    }

    
    function modifyBooking(id,title,date){
        // 1. 'Would you like to cancel booking' Modal
        document.getElementById("booking_edit_modal").style.display = "block";
        let editModalText = document.getElementById("booking_edit_modal_text");
        editModalText.innerHTML = "Would you like to cancel : " + title + "? (" + date + ")";

        const content =  document.getElementById("modal_content");
        const node = document.createElement("button");
        const textnode = document.createTextNode("Cancel Booking");
        node.id = "cancel_button";
        node.onclick = function() {cancelBooking(id)};
        node.appendChild(textnode);
        content.appendChild(node);
        
        // document.getElementById("cancel_button").onclick = function(){
        //     cancelBooking(id)
        // }
    }

    let editModal = document.getElementById("booking_edit_modal");
    editModal.style.display = "none";

    window.onclick = function(event) {
        if (event.target == editModal) {
            editModal.style.display = "none";
            document.getElementById("cancel_button").remove();
        }
    }

    function cancelBooking(booking_id){
        // 2. action a AJAX post request with JS remove child.
        let token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'DELETE',
            cache: false,
            url: '/bookings/' + booking_id,
            data: { "id": booking_id, "_token": token },
            success:function(data){
                // console.log("AJAX success" + data["msg"]);
                document.getElementById("booking_edit_modal").style.display = "none";
                document.getElementById("day_list_item" + booking_id).remove();
            }
        });
    }
    // [M]ust remove the submit button and replace with a 'loading...'
    // $(document).on({
    //     ajaxStart: function(){
    //         $body.addClass("loading"); },
    //     ajaxStop: function(){
    //         $body.removeClass("loading"); }    
    // });
</script>