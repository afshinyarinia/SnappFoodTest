<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\DelayedOrder;
use App\Services\ReportDelayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgentsController extends Controller
{
    private ReportDelayService $reportDelayService;

    public function __construct()
    {
        $this->reportDelayService = new ReportDelayService();
    }

    public function getReport(Agent $agent): JsonResponse
    {
        // see if the agent don't have any active order to process
        if($agent->hasActiveDelayedOrder()){
            return response()->json([
                'message' => 'You Already Have An Assigned Delayed Order To Resolve'
            ],400);
        }
        // Get a delayed order assigned to the agent
        $delayedOrder = $this->reportDelayService->assignDelayedOrder();
        if(!$delayedOrder){
            return response()->json([
                'message' => 'There Is No Delayed Orders Left'
            ],404);
        }
        $delayedOrder->update([
            'agent_id' => $agent->id,
            'status' => DelayedOrder::STATUS['ASSIGNED']
        ]);

        return response()->json([
            'message' => 'Delayed Order Fetched Successfully'
        ], 200);

    }
}
