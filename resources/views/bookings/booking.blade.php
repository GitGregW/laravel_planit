<x-layout>
    <x-slot name="content">
        <div id="calendar_container" class="calendar__container">
            {{-- Change Calendar Booking Month --}}
            @php
                $next_month = date("M-Y", strtotime($selected_date . ' first day of next month'));
                $prev_month = date("M-Y", strtotime($selected_date . ' first day of last month'));
                $selected_date = strtotime(str_replace("-"," ",$selected_date));
                $days = date("t", $selected_date);

                if($selected_date == strtotime(date("M-Y"))) $today = date("j");
                elseif($selected_date < strtotime(date("M-Y"))) $today = 32;
                else $today = 0;
            @endphp
            <div class="booking__planner booking__header">
                <h2 style="margin:0;">{{ $event->title }}</h2>
                <div class="booking__planner">
                    <a href="/bookings/{{ $event->slug }}/{{$prev_month}}" style="margin: auto 0;">
                        <svg class="feather" style="stroke: black;"><use href="/icons/feather-sprite.svg#chevron-left"/></svg>
                    </a>
                    <h2 id="selected_date" style="margin:0;">{{ date("M Y", $selected_date) }}</h2>
                    <a href="/bookings/{{ $event->slug }}/{{$next_month}}" style="margin: auto 0;">
                        <svg class="feather" style="stroke: black;"><use href="/icons/feather-sprite.svg#chevron-right"/></svg>
                    </a>
                </div>
            </div>

            <div class="booking__planner booking__planner__widgets">
                {{-- Event Calendar --}}
                @php
                    // Assign opening/closing times to the according date as the key.
                    $day_labels = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
                    $month_start = date("01-M-Y",$selected_date);
                    $day_start =  intval(date("N", strtotime($month_start))); // 1 (for Monday) through 7 (for Sunday)
                    $calendar_rows = ceil(($days + ($day_start - 1)) / 7);
                    foreach($event->event_opening_times as $opening_time){
                        $day_key = array_search($opening_time->day, $day_labels);
                        for ($i=0; $i < $calendar_rows; $i++) {
                            $key = ($day_key + ($i * 7)) - ($day_start - 1);
                            $event_times[$key]['open_time'] = $opening_time->opening_time;
                            $event_times[$key]['close_time'] = $opening_time->closing_time;
                        }
                    }
                @endphp
                <x-calendar :selected_date="$selected_date" :event_times="$event_times" class="calendar--monthly"></x-calendar>

                {{-- Users Planner --}}
                @php
                foreach($event_bookings as $event_booking){
                    $day = date('j', strtotime($event_booking["date"]));
                    $bookings[$day - 1][] = $event_booking;
                }
                @endphp
                <div id="user_schedule" class="user__schedule">
                    <h3 class="user__schedule__header">My Planner</h3>
                    <x-calendar :selected_date="$selected_date" :days="$days" :bookings="$bookings" list="1" class="calendar--daily"></x-calendar>
                    {{-- <div>
                        @if (isset($event_bookings))
                            @php
                                foreach($event_bookings as $event_booking){
                                    $day = date('j', strtotime($event_booking["date"]));
                                    $bookings[$day] = $event_booking;
                                }
                            @endphp
                            @for ($i = 1; $i <= $days; $i++)
                                    <div id="user_schedule_day{{ $i }}" class="schedule__data">
                                        <div class="calendar__date {{ $today == $i ? 'calendar__date--today' : '' }}">
                                            {{ date("D jS F", strtotime(date("Y-m-$i",$selected_date))) }}</div>
                                        <ul class="schedule__data" id="schedule_day_items{{ $i }}">
                                            @if (isset($bookings[$i]))
                                                <li>{{ date("g:ia: ", strtotime($bookings[$i]->time)).$bookings[$i]->title }}</li>
                                            @endif
                                        </ul>
                                    </div>
                            @endfor
                            @else
                            @for ($i = 1; $i <= $days; $i++)
                                <div id="user_schedule_day{{ $i }}" class="schedule__data">
                                    <div class="schedule__date {{ $today == $i ? 'calendar__date--today' : '' }}">
                                        {{ date("D jS F", strtotime(date("$i-M-Y",$selected_date))) }}</div>
                                    <ul class="schedule__data" id="schedule_day_items{{ $i }}"></ul>
                                    </div>
                            @endfor
                        @endif
                    </div> --}}
                </div>
                
                <!-- The Modal -->
                <div id="my_modal" class="modal">
                    <div class="modal__content">
                        <span class="close">&times;</span>
                        <button id="confirm_booking_body" type="submit" form="day_slots_form">Confirm Booking</button>
                    </div>
                </div>

            </div>
        </div>

    </x-slot>
</x-layout>

<script>

    function checkAvailability(day, open, close){
        // scheduleEffectIn(day);
        let date = new Date();
        date.setDate(day);
        date = date.toISOString().split('T')[0];

        // Calculate Open Hours.
        let start = open.split(":");
        let end = close.split(":");
        let startDate = new Date(0, 0, 0, start[0], start[1], 0);
        if(end[0] < start[0]){ var endDate = new Date(0, 0, 1, end[0], end[1], 0); }
        else{ var endDate = new Date(0, 0, 0, end[0], end[1], 0); }
        let diff = endDate.getTime() - startDate.getTime();
        let hours = Math.floor(diff / 1000 / 60 / 60);

        if(document.getElementById("day_slots_form")){
            document.getElementById("day_slots_form").remove();
        }
        
        // Form
        let formEl = document.createElement("form");
        formEl.id = 'day_slots_form';
        formEl.method = 'POST';
        formEl.action = '/bookings/{{ $event->id }}';
        let formWrap = document.getElementById("calendar_container");
        formWrap.appendChild(formEl);

        // Form Input CSRF
        let daySlotsForm = document.getElementById("day_slots_form");
        let csrfHidden = document.createElement("input");
        csrfHidden.type = 'hidden';
        csrfHidden.name = '_token';
        csrfHidden.value = '{{ csrf_token() }}';
        daySlotsForm.appendChild(csrfHidden);

        // Form Input-Select.
        let selectOptions = document.createElement("select");
        selectOptions.id = 'day_slots';
        selectOptions.name = 'day_slots';
        selectOptions.className = 'calendar__day__slots';
        selectOptions.size = hours;
        selectOptions.setAttribute("onchange", "confirmBooking('" + date + "', this.value)");
        daySlotsForm.appendChild(selectOptions);
        selectOptions.style.display = "grid";

        let j = 0;
        // Form Input-Select Options.
        for(let i = 0; i < hours; i++){
            let option = document.createElement("option");
            let slotHours = startDate.getHours() + i;
            if(slotHours >= 24){
                slotHours = j;
                j++;
            }
            let timeSlot = addZero(slotHours) + ":" + addZero(startDate.getMinutes());
            let node = document.createTextNode(timeSlot);
            option.appendChild(node);
            option.id = 'day_slot_' + slotHours;
            option.value = timeSlot;
            option.className = 'calendar__day__slot';
            selectOptions.style.display = "grid";
            selectOptions.appendChild(option);
        }
        function addZero(i) {
            if (Number(i) < 10) { return "0" + i; }
            else return i;
        }

        // Form Offset position
        let dayBlock = document.getElementById("day" + day);
        let dayOffsetTop = dayBlock.offsetTop;
        let dayOffsetLeft = dayBlock.offsetLeft;
        let daySlots = document.getElementById("day_slots");
        daySlots.style.top = (dayOffsetTop + 30) + "px";
        daySlots.style.left = (dayOffsetLeft + 20) + "px";
    }

    function confirmBooking(date, open){
        // If the modal is being displayed; prevent user from changing selected date behind the modal.
            // document.getElementById("day_slots").disabled = true;

        // Display Modal
        document.getElementById("my_modal").style.display = "block";
        let dateFormatted = new Date(date + " " + open);
        let scheduleEntry = formatAMPM(dateFormatted) + ': {{ $event->title }}';
        document.getElementById("user_schedule").className = 'user__schedule--modal__on';

        // Amend form input as DateTime
        document.getElementById("day_slot_" + dateFormatted.getHours()).value = date + " " + open;

        // Review Schedule with appended event.
        const node = document.createElement("li");
        const textnode = document.createTextNode(scheduleEntry);
        node.appendChild(textnode);
        node.id = 'schedule_{{ $event->id }}';
        node.className = 'day__list__item';
        console.log("day_list" + dateFormatted.getDate());
        document.getElementById("day_list" + dateFormatted.getDate()).appendChild(node);
    }

    let modal = document.getElementById("my_modal");
    modal.style.display = "none";

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            document.getElementById("user_schedule").className = 'user__schedule';
            document.getElementById("day_slots_form").remove();
            document.getElementById("schedule_{{ $event->id }}").remove();
        }
    }

    // StackOverflow formatter function
    function formatAMPM(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ampm;
        return strTime;
    }
</script>