@props(['events'])

<div class="card__container">
    @foreach ($events as $event)
        <x-events.card :event="$event" />
    @endforeach
</div>