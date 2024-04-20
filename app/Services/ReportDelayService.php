<?php

namespace App\Services;

use App\Models\Agent;
use App\Models\DelayedOrder;
use App\Models\DelayReport;
use App\Models\Order;
use App\Models\Trip;
use Illuminate\Support\Facades\Redis;

class ReportDelayService
{
    private GetEstimationsService $GetEstimationsService;

    public function __construct()
    {
        $this->GetEstimationsService = new GetEstimationsService();
    }

    public function reportDelay(Order $order): array
    {

        // check if the Order is actually delayed
        if($order->delivery_time > $order->created_at->diffInMinutes(now())){
            return [
                'message' => 'Order is not delayed',
                'status' => 400
            ];
        }
        // check if there is a trip associated with the order
        $trip = Trip::query()->whereIn('status',[
            Trip::STATUS['AT_VENDOR'],
            Trip::STATUS['PICKED'],
            Trip::STATUS['ASSIGNED'],
        ])->where('order_id',$order->id)->first();
        if($trip){
            // get a new estimation
            $response = $this->GetEstimationsService->getEstimations();
            // report the delay
            DelayReport::updateOrCreate(
                [
                    'order_id' => $order->id,
                    'type' => DelayReport::TYPE['ESTIMATED']
                ],
                [
                    'time' => $response['estimation']
                ]
            );
            return [
                'message' => 'Order Estimation has been updated',
                'status' => 200
            ];
        }
        // create a delay report
        $this->createDelayReport($order);
        return [
            'message' => 'Order has been reported as delayed',
            'status' => 200
        ];
    }

    private function createDelayReport(Order $order): void
    {
        $minutesSinceOrderCreation = $order->created_at->diffInMinutes(now());
        $delayInMinutes = $minutesSinceOrderCreation - $order->delivery_time;
        DelayReport::create([
            'order_id' => $order->id,
            'type' => DelayReport::TYPE['DELAYED'],
            'time' => $delayInMinutes
        ]);
        // push the order to the delay queue in redis
        DelayedOrder::create([
            'order_id' => $order->id
        ]);
    }

    public function assignDelayedOrder(): DelayedOrder|null
    {
        return DelayedOrder::where('status',DelayedOrder::STATUS['WITHOUT_OWNER'])->orderBy('id')?->first();
    }
}
