<?php

namespace App\Http\Controllers;

use App\Http\Resources\DelayReportResource;
use App\Models\Agent;
use App\Models\DelayedOrder;
use App\Services\ReportDelayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class AgentsController extends Controller
{
    private ReportDelayService $reportDelayService;

    public function __construct()
    {
        $this->reportDelayService = new ReportDelayService();
    }

    /**
     * @OA\Get(
     *     path="/api/agents/{agent}/get-report",
     *     summary="Assign A Delayed Order To An Agent",
     *     tags={"Agents"},
     *     @OA\HeaderParameter(name="Accept",parameter="accept/json"),
     *     @OA\PathParameter(name="agent", example="1"),
     *     @OA\Response(response="200", description="Delayed Order Fetched Successfully" ,@OA\JsonContent()),
     *     @OA\Response(response="400", description="You Already Have An Assigned Delayed Order To Resolve",@OA\JsonContent()),
     *     @OA\Response(response="404", description="There Is No Delayed Orders Left",@OA\JsonContent()),
     * )
     */
    public function getReport(Agent $agent): JsonResponse
    {
        // see if the agent don't have any active order to process
        if($agent->hasActiveDelayedOrder()){
            $delayedOrder = DelayedOrder::where('agent_id',$agent->id)
                ->where('status',DelayedOrder::STATUS['ASSIGNED'])
                ->first();
            return response()->json([
                'data' => DelayReportResource::make($delayedOrder),
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
            'data' => DelayReportResource::make($delayedOrder),
            'message' => 'Delayed Order Fetched Successfully'
        ], 200);

    }
}
