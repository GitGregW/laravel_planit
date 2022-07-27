<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventOpeningTime>
 */
class EventOpeningTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // 'day' => $this->faker->unique()->randomElements(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']),
        return [
            // 'event_id' => Event::factory(),
            'opening_time' => $this->faker->time('H:00:00'),
            'closing_time' => $this->faker->time('H:00:00')
            // 'custom_date'
            // 'custom_repeat_yearly'
            //
        ];
    }
}