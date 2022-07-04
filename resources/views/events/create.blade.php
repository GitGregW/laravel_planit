<script src="/js/events/create.js"></script>
<x-layout>
    <x-slot name="content">
        <picture class="event__create__background">
            {{-- <source srcset="/images/unsplash/planit/usgs-hSh_X3kJ4bI-unsplash.jpg"> --}}
            <img src="/images/unsplash/planit/usgs-hSh_X3kJ4bI-unsplash.jpg" alt="">
        </picture>
        @if($errors->any())
            {{-- Create an error component here: bordered, aligned centered, list
                *Also, include inline error styling i.e. red form element border --}}
        @endif
        <form class="event__form" method="POST" action="/events/create">
            <div class="event__title"><h2>Add Your Event</h2></div>
            @csrf
            <div class="event__form__header">
                <input id="title"  type="text" name="title"
                    placeholder="Event Name" value="{{ old('title')}}">
                <textarea id="body" name="body" style="padding: 0.5em 1em; border-radius: 0.25em;" placeholder="Event Description"
                    value="{{ old('body')}}" rows='4'></textarea>
            </div>
            {{-- [C] Check for free postcode lookup. --}}
                <fieldset class="form__fieldset">
                    <legend>Address</legend>
                    <input class="event__form__address1" type="text"
                    id="address_line_1" name="address_line_1"
                    placeholder="Address Line 1" value="{{ old('address_line_1')}}">
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
                </fieldset>
                <fieldset class="event__form__wrap--contact form__fieldset">
                    <legend>Contact</legend>
                    <input class="event__form__landline" type="text"
                    id="contact_landline" name="contact_landline"
                    placeholder="Landline Number" value="{{ old('contact_landline')}}">
                    <input class="event__form__mobile" type="text"
                    id="contact_mobile" name="contact_mobile"
                    placeholder="Mobile Number" value="{{ old('contact_mobile')}}">
                </fieldset>

                <fieldset class="form__fieldset">
                    {{-- To create: 'categories' table and 'event_categories' --}}
                    <legend>Event Categories</legend>
                    <select class="event__form__categories" id="event_categories" name="event_categories"
                        onChange="categorySelections()" size="6" multiple>
                        {{-- <option id="event_category" value="nature">Nature</option>
                        <option id="event_category" value="zoo">Zoo</option>
                        <option id="event_category" value="paddle boarding">Paddle Boarding</option>
                        <option id="event_category" value="gardens">Gardens</option>
                        <option id="event_category" value="paintballing">Paintballing</option>
                        <option id="event_category" value="kart racing">Kart Racing</option> --}}
                        @foreach (\App\Models\Category::all() as $category)
                            <option id="event_category" value={{$category->id}}
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <input class="event__form__category" type="text" style="display: inline"
                        id="event_category_add" name="event_category_add" placeholder="Your Category"
                    >
                    <button class="event__form__button" id="category_button" name="category_button" onclick="addCategory()">Add Category</button>
                </fieldset>
                <fieldset class="form__fieldset event__fieldset__images"
                        style="margin: 1em 5%; text-align: center;">
                    <legend>Event Images</legend>
                    
                    <div id="category_selections" name="category_selections" class="event__category__selections"></div>
                    
                    <input class="event__form__image" type="text" style="display: inline"
                        id="contact_image" name="contact_image" placeholder="Lookup Event" disabled>

                    <div class="event__image__count">
                        <svg class="feather event__image__svg" onclick="decrementImage()" style="stroke: black; margin: 0 0.25em;"><use href="/icons/feather-sprite.svg#minus-square"/></svg>
                        <input id="image_count" class="event__form__image__count" type="text" style="width:2em;" value="2" />
                        <svg class="feather event__image__svg" onclick="incrementImage()" style="stroke: black; margin: 0 0.25em;"><use href="/icons/feather-sprite.svg#plus-square"/></svg>
                    </div>

                    <button class="event__form__button" id="image_button" name="image_button" onclick="getImages()">Search Image</button>
        
                    {{-- View example image: option to add multiple images --}}
                    {{-- <input type="image" src="" alt="" id="contact_image_1" name="contact_image_1"> --}}
                    
                    <div class="event__image__container" id="image_view" name="image_view"></div>
                
                </fieldset>
                

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
        }

        function galleryRibbon(images){
            event.preventDefault();
            let ribbon = '';
            let len = images.length;
            for (let i = 0; i < len; i++) {
                ribbon += '<picture id="event_picture_' + i + '" class="event__image__wrap">';
                    ribbon += '<img class="event__image" src=' + images[i] + ' onclick="viewImage(\'' + images[i] + '\')" />';
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
</script>