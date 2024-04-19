<?php

use App\Models\DelayReport;
use App\Models\Order;
use App\Models\Trip;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    // create 5 vendor with 2 delayed order each
    $this->vendor = Vendor::factory()->count(5)->create()
    ->each(function (Vendor $vendor) {
        return $vendor->orders()->saveMany(Order::factory()->count(2)->create([
            'vendor_id' => $vendor->id,
            'status' => Order::STATUS["DELAYED"]
        ]));
    });
    // create a trip and delayed report for each order
    Order::each(function (Order $order) {
        $order->trip()->save(Trip::factory()->create([
            'status' => $this->faker->randomElement([Trip::STATUS['ASSIGNED'],Trip::STATUS['PICKED']]),
            'order_id' => $order->id,
        ]));
        $order->delayReports()->save(DelayReport::factory()->create([
            'type' => DelayReport::TYPE['DELAYED'],
            'order_id' => $order->id,
        ]));
    });
});

test('vendor can see the report of its delayed orders', function () {

    $response = $this->get(route('vendors.get-delayed-orders-report'));

    // assert
    $response->assertStatus(200);
    $this->assertCount(5,$response->json('data'));
    $vendor = Vendor::withCount(['delays as total_delay_time' => function ($query) {
        $query->select(DB::raw('SUM(delay_time)'));
    }])
        ->orderBy('total_delay_time','desc')
        ->first();
    $this->assertEquals($response->json('data.0.delayed'),$vendor->total_delay_time);
});
