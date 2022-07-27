<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventBooking>
 */
class EventBookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Whenever the DB is seeded then match the bookings with the seeded Event and User factory seeds.
        $count_users = User::count();
        $count_events = Event::count();

        return [
            'event_id' => $this->faker->numberBetween(($count_events - 8), $count_events),
            'user_id' => $this->faker->numberBetween(($count_users - 4), $count_users),
            'date' => $this->faker->dateTimeBetween('-6 week', '+6 week'),
            'price' => $this->faker->randomFloat(2, 0, 30),
            'discount' => $this->faker->randomFloat(2, 0, 1)
        ];
    }
}
