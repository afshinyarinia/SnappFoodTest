<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendor_id' => $this->faker->numberBetween(1, 10),
            'trip_id' => $this->faker->numberBetween(1, 10),
            'order_number' => $this->faker->unique()->randomNumber(8),
            'status' => $this->faker->randomElement(['assigned', 'at_vendor', 'picked', 'delivered']),
            'total' => $this->faker->randomFloat(2, 10, 100),
            'delivery_time' => $this->faker->dateTimeBetween('now', '+1 week'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
