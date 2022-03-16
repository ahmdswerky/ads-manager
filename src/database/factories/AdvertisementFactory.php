<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Enum\AdvertisementType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(50),
            'description' => $this->faker->realText(800),
            'type' => $this->faker->randomElement([
                AdvertisementType::FREE,
                AdvertisementType::PAID,
            ]),
            'user_id' => User::inRandomOrder()->select(['id'])->first()->id,
            'start_date' => $this->faker->dateTimeBetween('-3 days', '+3 days'),
        ];
    }
}
