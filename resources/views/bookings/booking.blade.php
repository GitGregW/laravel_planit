<x-layout>
    <x-slot name="content">
        <div class="calendar__container">
            @php
                $selected_date = time();
                $days = date("t", $selected_date);
            @endphp
            
            <div class="booking__planner booking__header">
                <h2>{{ $event->title }}</h2>
                <div class="booking__planner">
                    <svg class="feather" style="stroke: black;height: inherit;"><use href="/icons/feather-sprite.svg#chevron-left"/></svg>
                    <h2><span id="selected_date">{{ date("M Y", $selected_date) }}</span></h2>
                    <svg class="feather" style="stroke: black;height: inherit;"><use href="/icons/feather-sprite.svg#chevron-right"/></svg>
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
                        <button id="confirm_booking_body">Confirm Booking</button>
                    </div>

                </div>
                <div id="user_schedule" class="user__schedule">
                    <h3 class="user__schedule__header">My Planner</h3>
                    <table class="user__schedule__table">
                        @for ($i = 1; $i <= $days; $i++)
                            <tr>
                                <td id="user_schedule_day{{ $i }}" class="schedule__data">
                                    <div class="schedule__date">{{ date("D jS F", strtotime(date("$i-M-Y",$selected_date))) }}</div>
                                    <ul class="schedule__data" id="schedule_day_items{{ $i }}"></ul>
                                </td>
                            </tr>
                        @endfor
                    </table>
                </div>
            </div>
        </div>

    </x-slot>
</x-layout>

<script>
    function checkAvailability(day, date, open, close){
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

        // Form Input Wrapper remove.
        if(document.getElementById("day_slots_wrapper")){
            document.getElementById("day_slots_wrapper").remove();
        }
        // Form Input Wrapper create.
        let formWrap = document.createElement("div");
        formWrap.setAttribute('id', 'day_slots_wrapper');
        let dayI = document.getElementById("day" + day);
        dayI.appendChild(formWrap);

        // Form Input-Select.
        let selectOptions = document.createElement("select");
        selectOptions.setAttribute('id', 'day_' + day + '_slots');
        selectOptions.setAttribute('name', 'day_' + day + '_slots');
        selectOptions.setAttribute('class', 'calendar__day__slots');
        selectOptions.setAttribute('size', hours);
        selectOptions.setAttribute('onChange', "confirmBooking('" + date + "', this.value)");
        let daySlots = document.getElementById("day_slots_wrapper");
        daySlots.appendChild(selectOptions);
        selectOptions.style.display = "grid";

        // Form Input-Select Options.
        for(let i = 0; i < hours; i++){
            let item = document.createElement("option");
            let timeSlot = addZero(startDate.getHours(), i) + ":" + addZero(startDate.getMinutes());
            let node = document.createTextNode(timeSlot);
            item.appendChild(node);
            item.setAttribute('id', 'day_' + day + '_slot');
            item.setAttribute('value', timeSlot);
            // item.setAttribute('onclick', "confirmBooking(\"" + date + "\", \"" + timeSlot + "\")");
            item.setAttribute('class', 'calendar__day__slot');
            selectOptions.style.display = "grid";
            selectOptions.appendChild(item);
        }
            function addZero(i, h = 0) {
                if (Number(i) + h < 10) { i = "0" + (i + h); }
                else { i += h; }
                return i;
            }
    }

    function confirmBooking(date, open){
        modal.style.display = "block";
        document.getElementById("my_modal").style.display = "block";
        let dateFormatted = new Date(date + " " + open);
        let scheduleEntry = '<strong>{{ $event->title }}</strong> ' + formatAMPM(dateFormatted);
        let schedule = document.getElementById("user_schedule");
        schedule.style.zIndex = '3';
        schedule.style.height = '22em';
        schedule.style.position = 'fixed';
        schedule.style.alignSelf = 'auto';
        addEvent(scheduleEntry);
    }

    function addEvent(day){
        if(document.getElementById("calendar_{{ $event->slug }}")){
            document.getElementById("calendar_{{ $event->slug }}").remove();
            document.getElementById("schedule_{{ $event->slug }}").remove();
        }
        const item = document.createElement("li");
        const node = document.createTextNode("{{ $event->title }}");
        item.appendChild(node);
        item.setAttribute('id', 'schedule_{{ $event->slug }}');
        item.setAttribute('class', 'schedule__day__item');
        document.getElementById("schedule_day_items" + day).appendChild(item); //.appendChild(item.cloneNode(true));
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
            document.getElementById("day_slots_wrapper").remove();
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
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }
</script>