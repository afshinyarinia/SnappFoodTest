<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\DelayedOrder;
use App\Models\DelayReport;
use App\Models\Order;
use App\Models\Trip;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Vendor;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create 10 vendors when each have 5 orders
        $vendors = Vendor::factory()->count(10)->create();


        $vendors->each(function ($vendor) {
            $vendor->orders()->saveMany(Order::factory()->count(5)->create([
                'vendor_id' => $vendor->id
            ]));
        });
        // create random delayed orders
        $orders = Order::inRandomOrder()->limit(5)->get();
        $orders->each(function (Order $order) {
            DelayReport::factory()->create([
                'order_id' => $order->id,
            ]);
        });

        // create 5 agents
        Agent::factory()->count(5)->create();
        // create order for api check that is delayed
        $order = Order::factory()->create([
            'delivery_time' => 30,
            'status' => Order::STATUS["ON_THE_WAY"],
            'created_at' => Carbon::now()->subHours(2)
        ]);

    }
}
