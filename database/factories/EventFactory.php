<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $slug = $this->faker->slug(3, false);
        $title = ucwords(str_replace('-',' ',$slug));

        return [
            'user_id' => $this->faker->randomDigitNot(0),
            'event_image_id' => $this->faker->randomDigitNot(0),
            'event_category_id' => $this->faker->randomDigitNot(0),
            'event_booking_id' => $this->faker->randomDigitNot(0),
            'slug' => $slug,
            'title' => $title,
            'body' => $this->faker->paragraphs(2, true),
            'address_line_1' => $this->faker->buildingNumber(). ' ' . $this->faker->streetName(),
            'address_line_2' => $this->faker->secondaryAddress(),
            'address_city' => $this->faker->city(),
            'address_county' => $this->faker->county(),
            'postcode' => $this->faker->postcode(),
            'contact_mobile' => $this->faker->mobileNumber(),
            'contact_landline' => $this->faker->phoneNumber(),
            'rating' => $this->faker->randomFloat(1, 1, 5)
        ];
        
    }
}
