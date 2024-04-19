<?php

use App\Models\DelayReport;
use App\Models\Order;
use App\Models\Trip;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

beforeEach(function () {
    $this->vendor = Vendor::factory()->create();
    $this->order = Order::factory()->create([
        'vendor_id' => $this->vendor->id,
        'delivery_time' => 60,
        'created_at' => Carbon::now()->subMinutes(10),
        'updated_at' => Carbon::now(),
    ]);

});

test('user can report a delay on order if requirements filled', function () {
    // Set the current time to the next hour
    Carbon::setTestNow(Carbon::now()->addHour());
    $response = $this->postJson(route('order.report-delay', [
            $this->order->id,
        ]));
    // assert that there is a response
    $response->assertStatus(200);
    // see if there is order in delayed_orders table
    $this->assertDatabaseHas('delay_reports',[
        'order_id' => $this->order->id
    ]);
    $this->assertDatabaseHas('delay_reports', [
        'order_id' => $this->order->id,
        'type' => DelayReport::TYPE['DELAYED'],
    ]);

});

test('use can not report a delay on order that is not delayed', function () {
    // Set the current time to the next hour
    Carbon::setTestNow(Carbon::now()->subMinutes(5));
    $response = $this->postJson(route('order.report-delay', [
            $this->order->id,
        ]));
    // assert that there is a response
    $response->assertStatus(400);
});

test('user will get a new estimation if the trip is assigned', function () {
    // mock the http call to the external API
    Http::fake([
        config('services.estimation.url') => Http::response([
            'estimation' => 60, // new estimation in minutes
            'message' => 'Estimation fetched successfully'
        ], 200),
    ]);

    Trip::create([
        'order_id' => $this->order->id,
        'status' => Trip::STATUS['ASSIGNED'],
    ]);
    // Set the current time to the next hour
    Carbon::setTestNow(Carbon::now()->addHour());
    $response = $this->postJson(route('order.report-delay', [
            $this->order->id,
        ]));
    // assert that there is a response
    $response->assertStatus(200);

    // assert that the delay report was created
    $this->assertDatabaseHas('delay_reports', [
        'order_id' => $this->order->id,
        'type' => DelayReport::TYPE['ESTIMATED'],
        'time' => 60,
    ]);

    // assert that the response message is correct
    $response->assertJson([
        'message' => 'Order Estimation has been updated'
    ]);
});
