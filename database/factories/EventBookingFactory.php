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
        // Assign a random User and Event to an Event Booking.
        $count_users = User::count();
        $count_events = Event::count();

        return [
            'event_id' => $this->faker->numberBetween(1, $count_events),
            'user_id' => $this->faker->numberBetween(1, $count_users),
            'date' => $this->faker->dateTimeBetween('-6 week', '+12 week'),
            'time' => $this->faker->time('H:00:00'),
            'price' => $this->faker->randomFloat(2, 0, 30),
            'discount' => $this->faker->randomFloat(2, 0, 1)
        ];
    }
}
