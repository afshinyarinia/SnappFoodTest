<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\DelayedOrder;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DelayedOrder>
 */
class DelayedOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'agent_id' => Agent::factory()->create()->id,
            'order_id' => Order::factory()->create()->id,
            'reason' => $this->faker->words(10),
            'status' => $this->faker->randomElement(DelayedOrder::STATUS)
        ];
    }
}
