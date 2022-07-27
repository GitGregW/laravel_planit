<x-layout>
    <x-slot name="content">
        <div class="images__container">
            @foreach ($event->event_images as $image)
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
            <div>
                <button style="display: block"><a href="/bookings/{{ $event->slug }}">Plan Now</a></button>
            </div>
            <div class="event__header__content">
                
                <h2 class="event__header__title">{{ $event->title }}</h2>
                    <span class="event__header__rating">
                        <svg class="icon icon--star"
                                style="vertical-align: baseline"><use href="/icons/feather-sprite.svg#star"/></svg>
                        {{$event->rating}}</span>
                    <div>
                        @foreach ($event->categories as $category)
                            <span class="event__category__pill">{{$category->name}}</span>
                        @endforeach
                    </div>
                
                <p class="event__header__body">{{$event->body}}</p>
            </div>
            <div class="event__header__contact">
                <div>
                    <h4>Opening Times</h4>
                    @php( $schedules = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday','Bank Holidays') )
        
                    <table>
                    @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{$schedule}}</td>
                        @php ( $open = 0 )
                        @foreach ($event->event_opening_times as $opening_time)
                            @if ($schedule == $opening_time->day)
                                <td>{{ $opening_time->opening_time }} - {{ $opening_time->closing_time }}</td>
                                @php ( $open = 1 )
                            @endif
                        @endforeach
                        @if (!$open)
                            <td><span id="open_status">Closed</span></td>
                        @endif
                    </tr>
                    @endforeach
                    </table>
                </div>
                <div>
                    <h4>Contact</h4>
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
        </div>


        <div class="event__map">
                MAP GOES HERE.
        </div>
    </x-slot>
</x-layout>