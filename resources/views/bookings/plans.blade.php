<x-layout>
    <x-slot name="content">
        <div id="calendar_container" class="calendar__container">
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
                <h2 style="margin:0;">My Planner</h2>
                <div class="booking__planner">
                    <a href="/bookings/{{auth()->user()->id}}/review/{{$prev_month}}" style="margin: auto 0;">
                        <svg class="feather" style="stroke: black;"><use href="/icons/feather-sprite.svg#chevron-left"/></svg>
                    </a>
                    <h2 id="selected_date" style="margin:0;">{{ date("M Y", $selected_date) }}</h2>
                    <a href="/bookings/{{auth()->user()->id}}/review/{{$next_month}}" style="margin: auto 0;">
                        <svg class="feather" style="stroke: black;"><use href="/icons/feather-sprite.svg#chevron-right"/></svg>
                    </a>
                </div>
                <div id="switch__container">
                    <span class="switch__text">Daily view</span>
                    <label class="switch">
                        <input id="switch_view" type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                    <span class="switch__text">Monthly view</span>
                </div>
            </div>
            @php
                foreach($event_bookings as $event_booking){
                    $day = date('j', strtotime($event_booking["date"]));
                    $bookings[$day - 1][] = $event_booking;
                }
                // dd($bookings);
            @endphp
            <x-calendar :selected_date="$selected_date" :bookings="$bookings" class="calendar--monthly"></x-calendar>
        </div>
    </x-slot>
</x-layout>

<script>
    let switchView = document.getElementById("switch_view");
    let calendar = document.getElementById("calendar");
    let calendarLabel = document.getElementsByClassName("calendar__label");
    let calendarBlank = document.getElementsByClassName("day--blank");
    // console.log(window.innerWidth);

    switchView.addEventListener("change", function(){
        switchViewFunction(switchView.checked);
    });

    window.addEventListener('resize', function(event){
        if(window.innerWidth < 1300){
            switchViewFunction(0);
            document.getElementById("switch__container").style.display = "none";
        }
        else{
            switchViewFunction(1);
            document.getElementById("switch__container").style.display = "block";
        }
    }, true);

    function switchViewFunction(checked = 0){
        console.log("fn called: " + checked);
        if(!checked){
            for (let i = 0; i < calendarLabel.length; i++) {
                    calendarLabel[i].style.display = "none";
                }
                for (let i = 0; i < calendarBlank.length; i++) {
                    calendarBlank[i].style.display = "none";
                }
                calendar.className = 'calendar--daily';
            }
            else{
                for (let i = 0; i < calendarLabel.length; i++) {
                    calendarLabel[i].style.display = "block";
                }
                for (let i = 0; i < calendarBlank.length; i++) {
                    calendarBlank[i].style.display = "block";
                }
                calendar.className = "calendar--monthly";
            }
    }
</script>