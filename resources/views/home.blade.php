<x-layout>
    <x-slot name="content">
        <div class="card-header">
            <h2>Recently Added</h2>
            <p class="card__text-header">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Dolor magna eget est lorem ipsum dolor sit amet.
            </p>
        </div>

        <!-- card component here -->

        <!-- card component replace above -->
        <div style="position: relative;border-bottom: 4px solid #FF005C;height:30px; width:60%; margin: 0 0 40px 20%">
            <h2 class="card__title" style="position: absolute;top: 50%;left: 40%;"><a href="/explore">Explore More</a></h2>
        </div>

        <!-- Are you a business? List It. START -->
        <div class="interval-background" style="display:flex; background-color:#e9e8ce; width: 100%;">
        <div style="width:100%; margin: 2% 10% 2% 10%;">
            <h2 style="font-size: 20px;text-align: center;">Collaborate your events with the world!</h2>
            <div class="card-business-container">
                <div style="width:100%;">
                    <span>
                        <svg class="feather" style="width: 48px; height: 48px; stroke: orange;"><use href="/icons/feather-sprite.svg#briefcase"/></svg>
                    </span>
                    <h2 style="font-size: 18px;">Local Businesses</h2>
                </div>
                <div style="width:100%;">
                    <span>
                        <svg class="feather" style="width: 48px; height: 48px; stroke: blue;"><use href="/icons/feather-sprite.svg#share-2"/></svg>
                    </span>
                    <h2 style="font-size: 18px;">Councils</h2>
                </div>
                <div style="width:100%;">
                    <span>
                        <svg class="feather" style="width: 48px; height: 48px; stroke: red;"><use href="/icons/feather-sprite.svg#heart"/></svg>
                    </span>
                    <h2 style="font-size: 18px;">Charities</h2>
                </div>
            </div>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Dolor magna eget est lorem ipsum dolor sit amet.
            </p>
            <p><a class="navbar" href="/events/create" style="float: right;padding-right: 20%;">Create an Event here</a></p>
        </div>
        </div>
        <!-- Are you a business? List It. END -->

        <div class="card-header">
            <h2>Free Events</h2>
            <p class="card__text-header">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Dolor magna eget est lorem ipsum dolor sit amet.
            </p>
        </div>
        <!-- card component here -->

        <!-- card component replace above -->
    </x-slot>
</x-layout>