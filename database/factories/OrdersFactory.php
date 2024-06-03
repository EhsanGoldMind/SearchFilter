<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return fake(User::class)->create()->id;
            },
            'subject' => fake()->sentence,
            'description' => fake()->paragraph,
            'amount' => fake()->randomNumber(8),
            'status' => fake()->numberBetween(0, 3),
        ];
    }
}
