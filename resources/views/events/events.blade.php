<x-layout>
    <x-slot name="content">
        <div class="card-container">
            @foreach ($events as $event)
                <x-card :event="$event" />
            @endforeach
        </div>
    </x-slot>
</x-layout>