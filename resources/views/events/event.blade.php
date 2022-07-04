<x-layout>
    <x-slot name="content">
        <div class="images__container">
            @foreach ($event->event_image as $image)
                @php
                list($width, $height) = getimagesize('.'.$image->src);
                $is_portrait = false;
                @endphp
                @if ($height >= $width)
                    @php ($is_portrait = true)
                @endif

                <img class="card__image image__rounded {{ $is_portrait ? 'image__shrink' : '' }}" src={{ $image->src }} />
            
            @endforeach
        </div>

        <div class="event__header">
            <div class="event__header__content">
                <h2 class="event__header__title">{{ $event->title }}</h2>
                    <span class="event__header__rating">
                        <svg class="icon icon--star"
                                style="vertical-align: baseline"><use href="/icons/feather-sprite.svg#star"/></svg>
                        {{$event->rating}} see reviews</span>
                <p class="event__header__body">{{$event->body}}</p>
            </div>
            <div class="event__header__contact">
                <p>
                    {{ $event->address_line_1 }} <br />
                    {{ $event->address_line_2 }} <br />
                    {{ $event->address_city }} <br />
                    {{ $event->address_county }} <br />
                    {{ $event->postcode }} <br />
                </p>
                <hr />
                <p>
                    {{ $event->contact_landline }} <br />
                    {{ $event->contact_mobile }}
                </p>
            </div>
        </div>

        <div class="event__map">
                MAP GOES HERE.
        </div>
    </x-slot>
</x-layout>