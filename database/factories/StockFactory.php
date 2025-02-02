<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => $this->faker->randomDigit(),
            'qty' => $this->faker->randomNumber(3, false),
            'type' => $this->faker->randomElement(['in', 'out']),
            'amount' => $this->faker->randomNumber(6, false),
            'date' => $this->faker->dateTimeThisDecade(),
            'description' => $this->faker->sentence(4),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
