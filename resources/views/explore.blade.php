<?php
    $image_source = array(
        '/images/unsplash/events/liliana-morillo-ditAtitbnBU-unsplash.jpg',
        '/images/unsplash/events/sajad-baharvandi-tJJ8ULHTI44-unsplash.jpg',
        '/images/unsplash/events/mika-luoma-imtdvAUCbGU-unsplash.jpg');
?>

<x-layout>
    <x-slot name="content">
        <div class="card-header">
            <h2>Free Events</h2>
            <p class="card__text-header">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Dolor magna eget est lorem ipsum dolor sit amet.
            </p>
        </div>
        <div class="card-container">
            <x-card :image_source="$image_source[0]" />
            <x-card :image_source="$image_source[1]" />
            <x-card :image_source="$image_source[2]" />
            <x-card :image_source="$image_source[0]" />
            <x-card :image_source="$image_source[1]" />
            <x-card :image_source="$image_source[2]" />
        </div>
    </x-slot>
</x-layout>