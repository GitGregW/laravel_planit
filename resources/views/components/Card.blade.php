@props(['event'])

@php
    if(empty($event->event_image[0])) $image_source= '/images/unsplash/events/jason-leung-4BKiS_BgOwI-unsplash.jpg';
    else $image_source = $event->event_image[0]->src;
    //$image_source= '/images/unsplash/events/jason-leung-4BKiS_BgOwI-unsplash.jpg';
    list($width, $height) = getimagesize('.'.$image_source);
    $is_portrait = false;
@endphp

@if ($height >= $width)
    @php ($is_portrait = true)
@endif

<a href="/events/{{ $event->slug }}">
    <div class="card {{ $is_portrait ? 'card--portrait' : 'card--landscape' }}">
        <div class="card__image">
            <img class="card__image" src={{ $image_source }} />
            
                <svg class="icon icon--favourite" style="vertical-align: baseline"><use href="/icons/feather-sprite.svg#heart"/></svg>
            
            <div class="card__tags">
                <h2 class="card__tag">1 Space Remaining</h2>

            </div>
        </div>
        <div class="card__content {{ $is_portrait ? 'card__content--portrait' : '' }}">
            <h2 class="card__title">{{ $event->title }}</h2>
            <p class="card__text">{{ $event->body }}</p>
            
            <span class="card__button">
                View Details
                <svg class="icon icon--arrow-right-circle" style="vertical-align: baseline"><use href="/icons/feather-sprite.svg#arrow-right-circle"/></svg>
            </span>

        </div>
    </div>
</a>