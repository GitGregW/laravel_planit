<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventOpeningTime;
use App\Models\EventBooking;
use App\Models\Event;
use App\Models\Category;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Hard-coded assortment of categories
        // [C] Could break the Category table entries into a new SubCategory table.
        $categories_arr = array('nature','water_sports','go_karting',
            'street_food','beer_festival','classic_cars','music_performance','history',
            'christmas','halloween','new_years_day');

        $categories = Category::factory()
            ->count(count($categories_arr))
            ->sequence(fn ($sequence) => [
                'name' => ucwords(str_replace('_',' ', $categories_arr[$sequence->index])),
                'slug' => $categories_arr[$sequence->index]
                ])
            ->create();

        $users = User::factory()->count(5)->create();

        // $day_labels = collect(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']);
        // Every Event consits of 5 opening day times
        Event::factory()
            ->count(9)
            ->hasAttached($categories->shuffle()->take(4))
            ->create()
            ->each(function ($event){
                $days = collect(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'])->shuffle()->take(5);
                EventOpeningTime::factory()
                    ->count(5)
                    ->sequence(fn ($sequence) => ['day' => $days[$sequence->index]])
                    ->for($event)
                    ->create();
            });

        // Hardcoded seed factory in EventBooking for: User Count 5 & Event Count 9
        $event_bookings = EventBooking::factory()->count(20)->create();
            // ->count(4)
            // ->for($event)
            // ->create();

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
    }
}
