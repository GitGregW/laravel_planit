<x-layout>
    <x-slot name="content">
        @php
            // print_r($events[0]->event_images);
            // dd($events);
        @endphp
        <div class="card-container">
            @foreach ($events as $event)
                <x-card :event="$event" />
            @endforeach
        </div>
    </x-slot>
</x-layout>