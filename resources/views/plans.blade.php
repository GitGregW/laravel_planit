<x-layout>
    <x-slot name="content">
        <div class="calendar__container">
            <div class="calendar__header">
                <span class="calendar__selector">
                    @php ($selected_date = time())
                    {{ date("M Y", $selected_date) }} ^
                </span>
            </div>
            <!-- calendar logic: count events to show for month. Decrement count each time event is displayed to calendar. If 0 then end loop. -->
            <div class="calendar">
                <x-calendar :selected_date="$selected_date"></x-calendar>
            </div>
        </div>
    </x-slot>
</x-layout>