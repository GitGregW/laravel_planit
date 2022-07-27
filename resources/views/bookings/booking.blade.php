<x-layout>
    <x-slot name="content">
        <div id="calendar_container" class="calendar__container">
            @php
            // dd($event_bookings);
                $next_month = date("M-Y", strtotime($selected_date . ' first day of next month'));
                $prev_month = date("M-Y", strtotime($selected_date . ' first day of last month'));
                $selected_date = strtotime(str_replace("-"," ",$selected_date));
                $days = date("t", $selected_date);
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
                <div class="calendar calendar__event">
                    <x-calendar :selected_date="$selected_date" :event="$event"></x-calendar>
                </div>

                <!-- The Modal -->
                <div id="my_modal" class="modal">
                    <div class="modal__content">
                        <span class="close">&times;</span>
                        <button id="confirm_booking_body" type="submit" form="day_slots_form">Confirm Booking</button>
                    </div>
                </div>

                <div id="user_schedule" class="user__schedule">
                    <h3 class="user__schedule__header">My Planner</h3>
                    <table class="user__schedule__table">
                        @if ($event->event_bookings)
                        @for ($i = 1; $i <= $days; $i++)
                            <tr>
                                <td id="user_schedule_day{{ $i }}" class="schedule__data">
                                    <div class="schedule__date">{{ date("D jS F", strtotime(date("$i-M-Y",$selected_date))) }}</div>
                                    <ul class="schedule__data" id="schedule_day_items{{ $i }}">
                                    </ul>
                                </td>
                            </tr>
                        @endfor
                        @else
                        @for ($i = 1; $i <= $days; $i++)
                        <tr>
                            <td id="user_schedule_day{{ $i }}" class="schedule__data">
                                <div class="schedule__date">{{ date("D jS F", strtotime(date("$i-M-Y",$selected_date))) }}</div>
                                <ul class="schedule__data" id="schedule_day_items{{ $i }}"></ul>
                            </td>
                        </tr>
                        @endfor
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </x-slot>
</x-layout>

<script>
    function checkAvailability(day, date, open, close){
        console.log("checkAvailability fn called.");
        // Scroll to Planner Day.
        let userSchedule = document.getElementById("user_schedule");
        let scheduleScrollTo = document.getElementById("user_schedule_day" + day).offsetTop - document.getElementById("user_schedule_day1").offsetTop;
        userSchedule.scrollTop = scheduleScrollTo - 75;

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

        // Form Input-Select Options.
        for(let i = 0; i < hours; i++){
            let option = document.createElement("option");
            let slotHours = startDate.getHours() + i;
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
        let dayOffsetTop = document.getElementById("day" + day).offsetTop;
        let dayOffsetLeft = document.getElementById("day" + day).offsetLeft;
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
        let schedule = document.getElementById("user_schedule");
        schedule.style.zIndex = '3';
        schedule.style.height = '22em';
        schedule.style.position = 'fixed';
        schedule.style.alignSelf = 'auto';
        schedule.style.marginTop = '5px';

        console.log(dateFormatted.toLocaleString());
        // Amend form input as DateTime
        document.getElementById("day_slot_" + dateFormatted.getHours()).value = dateFormatted.toLocaleString();

        // Review Schedule with appended event.
        const item = document.createElement("li");
        const node = document.createTextNode(scheduleEntry);
        item.appendChild(node);
        item.id = 'schedule_{{ $event->id }}';
        item.className = 'schedule__day__item';
        document.getElementById("schedule_day_items" + dateFormatted.getDate()).appendChild(item);
    }

    let modal = document.getElementById("my_modal");
    modal.style.display = "none";

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            let schedule = document.getElementById("user_schedule");
            schedule.style.zIndex = '0';
            schedule.style.height = '50%';
            schedule.style.position = 'static';
            schedule.style.alignSelf = 'center';
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