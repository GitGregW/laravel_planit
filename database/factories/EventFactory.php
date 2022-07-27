<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
            // 'user_id' => User::factory(),
            'user_id' => 1, //$this->faker->randomDigitNotNull(),
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
