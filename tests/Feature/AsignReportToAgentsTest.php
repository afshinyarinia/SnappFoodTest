<?php

use App\Models\Agent;
use App\Models\DelayedOrder;
use App\Models\Order;
use App\Models\Vendor;
use Carbon\Carbon;

beforeEach(function () {
    $this->vendor = Vendor::factory()->create();
    $this->order = Order::factory()->create([
        'vendor_id' => $this->vendor->id,
        'delivery_time' => 60,
        'created_at' => Carbon::now()->subMinutes(10),
        'updated_at' => Carbon::now(),
    ]);
    $this->agent = Agent::factory()->create();
});

test('agent cant get an order if he has one already assigned to him', function () {
    DelayedOrder::factory()->create([
       'agent_id' => $this->agent->id,
       'status' => \App\Models\DelayedOrder::STATUS['ASSIGNED']
    ]);
    $response = $this->postJson(route('agents.agent.get-report',[
        'agent' => $this->agent->id
    ]));
    $response->assertStatus(400);
});

test('agent assigned a delayed order to process', function () {
    // create a delayed order
    $delayedOrder = DelayedOrder::factory()->count(5)->create([
        'agent_id' => null
    ]);
    $firstOrder = DelayedOrder::where('status',DelayedOrder::STATUS['WITHOUT_OWNER'])->orderBy('id')->first();
    $response = $this->postJson(route('agents.agent.get-report',[
        'agent' => $this->agent->id
    ]));
    $response->assertStatus(200);
    $assignedOrder = DelayedOrder::where('agent_id',$this->agent->id)->where('status',DelayedOrder::STATUS['ASSIGNED'])->first();
    $this->assertEquals($assignedOrder->id,$firstOrder->id);
});
