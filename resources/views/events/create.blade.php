<script src="/js/events/create.js"></script>
<x-layout>
    <x-slot name="content">
        <picture id="event_create_background" class="event__create__background">
            {{-- <source srcset="/images/unsplash/planit/usgs-hSh_X3kJ4bI-unsplash.jpg"> --}}
            <img src="/images/unsplash/planit/usgs-hSh_X3kJ4bI-unsplash.jpg" alt="">
        </picture>
        @if($errors->any())
            {{-- Create an error component here: bordered, aligned centered, list
                *Also, include inline error styling i.e. red form element border --}}
        @endif
        <div class="event__title"><h2>Add Your Event</h2></div>
        <form id="event_form" class="event__form" method="POST" action="/events">
            @csrf
            <div class="event__form__header">
                <input id="title"  type="text" name="title"
                    placeholder="Event Name" value="{{ old('title')}}">
                <textarea id="body" name="body" placeholder="Event Description"
                    value="{{ old('body')}}" rows='4'></textarea>
            </div>
            
            {{-- [C] Check for free postcode lookup. --}}
            <fieldset class="form__fieldset">
                <legend>Address + Contact</legend>
                <input class="event__form__address1" type="text"
                id="address_line_1" name="address_line_1"
                placeholder="Address Line 1" value="{{ old('address_line_1')}}">
                @error('address_line_1')
                    <p>{{ $message }}</p>
                @enderror
                <input class="event__form__address2" type="text"
                id="address_line_2" name="address_line_2"
                placeholder="Address Line 2" value="{{ old('address_line_2')}}">
                <input class="event__form__city" type="text"
                id="address_city" name="address_city"
                placeholder="City" value="{{ old('address_city')}}">
                <input class="event__form__county" type="text"
                id="address_county" name="address_county"
                placeholder="County" value="{{ old('address_county')}}">
                <input class="event__form__postcode" type="text"
                id="postcode" name="postcode"
                placeholder="Postcode" value="{{ old('postcode')}}">
                <br />
                <input class="event__form__landline" type="text"
                id="contact_landline" name="contact_landline"
                placeholder="Landline Number" value="{{ old('contact_landline')}}">
                <input class="event__form__mobile" type="text"
                id="contact_mobile" name="contact_mobile"
                placeholder="Mobile Number" value="{{ old('contact_mobile')}}">
            </fieldset>
            <fieldset class="event__form__wrap--contact form__fieldset form__fieldset--large">
                <legend>Opening Times</legend>
                {{-- After any selected case to return rows for remaining cases to add --}}
                {{-- After any custom date to return additional row to add another custom date --}}
                    <p>Specify your opening times below. <i>(default closed)</i></p>
                    <table class="schedule__table">
                        @php
                            $schedules = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday','bank_holidays','1');
                            $schedule_i = 0;
                        @endphp
                        @foreach ($schedules as $schedule)
                            <x-calendar.schedule :schedule="$schedule" :i="$schedule_i" />
                            @php ($schedule_i++)
                        @endforeach
                    </table>
                    <p><span><svg class="feather"><use href="/icons/feather-sprite.svg#plus-square"/></svg></span> Add Custom Opening Times</p>
                    {{-- I've removed the function out of the component loop to avoid duplication.
                        Only the event listeners are initialised in the component scripts. --}}
                    <script>
                        function openStatus(day){
                            let openingTime = document.getElementById("opening_times[" + day + "][opening_time]");
                            let closingTime = document.getElementById("opening_times[" + day + "][closing_time]");
                            let duration = document.getElementById("open_duration" + day);
                            let rowA = document.getElementById("row" + day + "a");
                            let rowB = document.getElementById("row" + day + "b");
                            if (openingTime.value && closingTime.value){
                                rowA.style.backgroundColor = rowB.style.backgroundColor = "palegreen";
                                start = openingTime.value.split(":");
                                end = closingTime.value.split(":");
                                var startDate = new Date(0, 0, 0, start[0], start[1], 0);
                                if(end[0] < start[0]) var endDate = new Date(0, 0, 1, end[0], end[1], 0);
                                else var endDate = new Date(0, 0, 0, end[0], end[1], 0);
                                var diff = endDate.getTime() - startDate.getTime();
                                var hours = Math.floor(diff / 1000 / 60 / 60);
                                diff -= hours * 1000 * 60 * 60;
                                var minutes = Math.floor(diff / 1000 / 60);
                                if(hours) hours = hours + " hr" + (hours > 1 ? "s" : "");
                                else hours = "";
                                if(minutes) minutes = minutes + " min" + (minutes > 1 ? "s" : "");
                                else minutes = "";
                                if(hours && minutes) duration.innerHTML = "Open: " + hours + ", " + minutes;
                                else duration.innerHTML = "Open: " + hours + minutes;
                            }
                            else{
                                rowA.style.backgroundColor = rowB.style.backgroundColor = "white";
                                duration.innerHTML = "";
                            }
                        }
                        // ... function hoursOpen() // that provides human readable hours/minutes open
                    </script>
                    {{-- if custom '1' has a date then incrememnt --}}
                </fieldset>
            
                <fieldset class="form__fieldset form__fieldset--tags">
                    <legend>Event Tags</legend>
                    <div class="category__column">
                        <p>Multiple Selection</p>
                        <select class="event__form__categories" id="event_categories" name="event_categories[]"
                            onChange="categorySelections()" size="6" multiple>
                            @foreach (\App\Models\Category::all() as $category)
                                <option id="event_category" name="event_category" value={{$category->id}}
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="category__column">
                        <p>Add categories</p>
                        <span class="category__add__wrap">
                            <input type="text" style="display: inline"
                                id="event_category_add" name="event_category_add" placeholder="Your Category">
                            <button class="category__add__button" style="font-size:18px;" id="category_button" name="category_button" onclick="addCategory()">+</button>
                        </span>
                    </div>
                </fieldset>

                <fieldset class="form__fieldset event__fieldset__images form__fieldset--large">
                    <legend>Event Images</legend>
                
                    <div id="category_selections" name="category_selections" class="event__category__selections"></div>
                
                    {{-- Input to be hidden; Images searched based on categories --}}
                    <input id="contact_image" name="contact_image" type="text" style="display:none" hidden>
                    <div class="event__image__count">
                        <svg class="feather event__image__svg" onclick="decrementImage()" style="stroke: black; margin: 0 0.25em;"><use href="/icons/feather-sprite.svg#minus-square"/></svg>
                        <input id="image_count" class="event__form__image__count" type="text" style="width:2em;" value="2" />
                        <svg class="feather event__image__svg" onclick="incrementImage()" style="stroke: black; margin: 0 0.25em;"><use href="/icons/feather-sprite.svg#plus-square"/></svg>
                    </div>
                    <button class="event__form__button" id="image_button" name="image_button" onclick="getImages()">Search Image</button>
                    <input type="text" id="event_images" name="event_images" style="display:none" hidden>
                    {{-- View example image: option to add multiple images --}}
                    {{-- <input type="image" src="" alt="" id="contact_image_1" name="contact_image_1"> --}}
                
                    <div class="event__image__container" id="image_view" name="image_view"></div>
                
                </fieldset>

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            <button class="event__form__submit" type="submit">Submit</button>
        </form>
    </x-slot>
</x-layout>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#image_view').hide();
    });

    const image1 = '/images/unsplash/events/frederick-medina-HLG35jI85V8-unsplash.jpg';
    const image2 = '/images/unsplash/events/fernando-lavin-fi5YSQfxbVk-unsplash.jpg';
    const image3 = '/images/unsplash/events/dillon-wanner-Bq0IG3mu-WY-unsplash.jpg';

    const images = [image1,image2,image3,image1,image2,image3,image1,image2,image3];

    function getImages(){
        event.preventDefault();
        $('#image_view').show();
        let content = '<div id="event_ribbon" class="event__image__ribbon"><div class="event__image__svg" style="position: absolute; left: 0;" onClick="scrollRibbon()"><svg class="feather" style="stroke: black;height: inherit;"><use href="/icons/feather-sprite.svg#chevron-left"/></svg></div>' + galleryRibbon(images) + '<div class="event__image__svg" style="position: absolute; right: 0;" onClick="scrollRibbon(\'right\')"><svg class="feather" style="stroke: black;height: inherit;"><use href="/icons/feather-sprite.svg#chevron-right"/></svg></div></div>';
        content += '<div class="event__image__view"><img id="large_image" class="event__image__large" src=' + images[0] + ' /></div>';
        document.getElementById('image_view').innerHTML = content;
        console.log(document.getElementById("event_create_background").style.height);
        // document.getElementById("event_create_background").style.height += document.getElementById("image_view").style.height;
        formImages();
    }

    function galleryRibbon(images){
        event.preventDefault();
        let ribbon = '';
        let len = images.length;
        for (let i = 0; i < len; i++) {
            ribbon += '<picture id="event_picture_' + i + '" class="event__image__wrap">';
                ribbon += '<img id="event_image" class="event__image" src=' + images[i] + ' onclick="viewImage(\'' + images[i] + '\')" />';
                ribbon += '<svg class="feather event__image__x" onClick="removePicture(\'event_picture_' + i  + '\')"><use href="/icons/feather-sprite.svg#x"/></svg>';
            ribbon += '</picture>';
        }
        return ribbon;
    }

    function viewImage(imageSrc){
        document.getElementById("large_image").src = imageSrc;
    }

    function scrollRibbon(direction){
        let ribbon = document.getElementById("event_ribbon");
        if (direction == "right"){
            ribbon.scrollBy(180,0);
        }
        else{
            ribbon.scrollBy(-180,0);
        }
    }

    function removePicture(picture){
        document.getElementById(picture).remove();
        formImages();
    }

    function addCategory(){
        event.preventDefault();
        const node = document.createElement("option");
        const textnode = document.createTextNode(toTitleCase(document.getElementById("event_category_add").value));
        node.setAttribute("id","event_category");
        node.appendChild(textnode);
        document.getElementById("event_categories").appendChild(node);
        document.getElementById("event_categories").lastChild.selected = true;
        document.getElementById("event_category_add").value = '';
        categorySelections();
    }

    function toTitleCase(str) {
        return str.replace(
            /\w\S*/g,
            function(txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            }
        );
    }

    function categorySelections(){
        let content = '';
        let search = '';
        let categories = document.getElementById("event_categories");
        for (let i = 0; i < categories.length; i++) {
            if (categories.options[i].selected) {
                search += categories.options[i].text + ' ';
                content += "<div class='event__category__pill'>" + categories.options[i].text + "</div>";
            }
        }
        document.getElementById("category_selections").innerHTML = content;
        document.getElementById('contact_image').value = search.substr(0, search.length-1);
    }

    function incrementImage(){
        let i = document.getElementById("image_count");
        if (i.value < 8){
            i.value++;
        }
    }

    function decrementImage(){
        let i = document.getElementById("image_count");
        if (i.value > 2){
            i.value--;
        }
    }

    function formImages(){
        const images = document.getElementsByTagName("img");
        let image_sources = '';
        for (let i = 0; i < images.length; i++) {
            if (images[i].id == "event_image"){
                image_sources += images[i].getAttribute("src") + ",";
            }
        }
        document.getElementById("event_images").value = image_sources.substr(0, image_sources.length-1)
        

        // document.getElementById("weekdays").addEventListener('click', addSchedule('weekdays') , false);

        // function addSchedule($schedule){
        //     return "<x-calendar.schedule :schedule=\"$schedule\" />";
        // }
    }
</script>