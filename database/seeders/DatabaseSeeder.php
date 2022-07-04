<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Event::factory(9)->create();

        \App\Models\EventImage::create([
            'event_id' => '1',
            'is_portrait' => true,
            'is_primary' => true,
            'src' => '/images/unsplash/events/aedrian-BshM9VkzGw8-unsplash.jpg'
        ]);
        \App\Models\EventImage::create([
            'event_id' => '1',
            'is_portrait' => true,
            'is_secondary' => true,
            'src' => '/images/unsplash/events/aedrian-slIzL6Rk4xI-unsplash.jpg'
        ]);

        \App\Models\EventImage::create([
            'event_id' => '2',
            'is_portrait' => true,
            'is_primary' => true,
            'src' => '/images/unsplash/events/al-nik-K0mrkZiTbfQ-unsplash.jpg'
        ]);
        \App\Models\EventImage::create([
            'event_id' => '2',
            'is_secondary' => true,
            'src' => '/images/unsplash/events/frederick-medina-HLG35jI85V8-unsplash.jpg'
        ]);

        \App\Models\EventImage::create([
            'event_id' => '3',
            'is_primary' => true,
            'src' => '/images/unsplash/events/john-thomas-LtE6W_JVTGc-unsplash.jpg'
        ]);
        \App\Models\EventImage::create([
            'event_id' => '3',
            'is_secondary' => true,
            'src' => '/images/unsplash/events/adam-whitlock-I9j8Rk-JYFM-unsplash.jpg'
        ]);

        \App\Models\EventImage::create([
            'event_id' => '4',
            'is_portrait' => true,
            'is_primary' => true,
            'src' => '/images/unsplash/events/dillon-wanner-W6hgIVl7-xM-unsplash.jpg'
        ]);
        \App\Models\EventImage::create([
            'event_id' => '4',
            'is_secondary' => true,
            'src' => '/images/unsplash/events/dillon-wanner-Bq0IG3mu-WY-unsplash.jpg'
        ]);
        
        \App\Models\EventImage::create([
            'event_id' => '5',
            'is_primary' => true,
            'src' => '/images/unsplash/events/jason-leung-4BKiS_BgOwI-unsplash.jpg'
        ]);
        \App\Models\EventImage::create([
            'event_id' => '5',
            'is_secondary' => true,
            'src' => '/images/unsplash/events/alex-suprun-AvIEqv1iY-4-unsplash.jpg'
        ]);

        \App\Models\EventImage::create([
            'event_id' => '6',
            'is_portrait' => true,
            'is_primary' => true,
            'src' => '/images/unsplash/events/ronan-furuta-JsV2hmFY3Jc-unsplash.jpg'
        ]);
        \App\Models\EventImage::create([
            'event_id' => '6',
            'is_portrait' => true,
            'is_secondary' => true,
            'src' => '/images/unsplash/events/ronan-furuta-wqodnf_H6zs-unsplash.jpg'
        ]);

        \App\Models\EventImage::create([
            'event_id' => '7',
            'is_primary' => true,
            'src' => '/images/unsplash/events/markus-spiske-qhgtBITGZeI-unsplash.jpg'
        ]);
        \App\Models\EventImage::create([
            'event_id' => '7',
            'is_portrait' => true,
            'is_secondary' => true,
            'src' => '/images/unsplash/events/markus-spiske-i1ksCIjm0dQ-unsplash.jpg'
        ]);
        
        \App\Models\EventImage::create([
            'event_id' => '8',
            'is_portrait' => true,
            'is_primary' => true,
            'src' => '/images/unsplash/events/gama-films-LHhzTa93XH0-unsplash.jpg'
        ]);
        \App\Models\EventImage::create([
            'event_id' => '8',
            'is_portrait' => true,
            'is_secondary' => true,
            'src' => '/images/unsplash/events/pradeep-charles-1AJZQiJ30ag-unsplash.jpg'
        ]);
        
        \App\Models\EventImage::create([
            'event_id' => '9',
            'is_primary' => true,
            'src' => '/images/unsplash/events/fernando-lavin-fi5YSQfxbVk-unsplash.jpg'
        ]);
        \App\Models\EventImage::create([
            'event_id' => '9',
            'is_secondary' => true,
            'src' => '/images/unsplash/events/shanna-camilleri-ljNQxfyN7AM-unsplash.jpg'
        ]);

        // Hard-coded assortment of categories
            // [C] Could break the Category table entries into a new SubCategory table.
        $categories = array(
            'christmas','halloween','new_years_day',
            'nature',
            'water_sports',
            'kart_racing',
            'street_food','beer_festival',
            'art_exhibition',
            'classic_car_show',
            'music_performance',
            'history'
        );

        foreach($categories as $category){
            \App\Models\Category::create([
                'slug' => $category,
                'name' => ucwords(str_replace('_',' ',$category)),
            ]);
        }
    }
}
