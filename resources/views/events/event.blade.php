<x-layout>
    <x-slot name="content">
        <div class="images__container">
            @foreach ($event[0]->event_images as $image)
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

        <div class="event__container">
            <div class="event__content">
                <div>
                    <h2 class="event__content__title">{{ $event[0]->title }}</h2>
                    <span class="event__content__title--item">
                        <svg class="icon icon--star"
                                style="vertical-align: baseline"><use href="/icons/feather-sprite.svg#star"/></svg>
                    {{$event[0]->rating}}</span>
                    <button class="event__content__title--item"><a href="/bookings/{{ $event[0]->slug }}">Plan Now</a></button>
                    <div class="event__content__categories">
                        @foreach ($event[0]->categories as $category)
                            <span class="event__category__pill">{{$category->name}}</span>
                        @endforeach
                    </div>
                </div>
                <p class="event__content__body">{{$event[0]->body}}</p>
            </div>
            <div class="event__content">
                <div>
                    <h4>Opening Times</h4>
                    @php( $schedules = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday','Bank Holidays') )
        
                    <table>
                    @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{$schedule}}</td>
                        @php ( $open = 0 )
                        @foreach ($event[0]->event_opening_times as $opening_time)
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
                        {{ $event[0]->address_line_1 }} <br />
                        {{ $event[0]->address_line_2 }} <br />
                        {{ $event[0]->address_city }} <br />
                        {{ $event[0]->address_county }} <br />
                        {{ $event[0]->postcode }} <br />
                    </p>
                    <hr />
                    <p>
                        {{ $event[0]->contact_landline }} <br />
                        {{ $event[0]->contact_mobile }}
                    </p>
                </div>

            </div>
        </div>


        <div class="event__map">
                MAP GOES HERE.
        </div>
    </x-slot>
</x-layout>