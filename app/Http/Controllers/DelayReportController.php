<?php

namespace App\Http\Controllers;

use App\Http\Requests\DelayReportRequest;
use App\Models\Order;
use App\Services\ReportDelayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class DelayReportController extends Controller
{
    private ReportDelayService $reportDelayService;

    public function __construct()
    {
        $this->reportDelayService = new ReportDelayService();
    }

    /**
     * @OA\Post(
     *     path="/api/orders/{order}/report-delay",
     *     summary="Order A Delayed Item",
     *     tags={"Orders"},
     *     @OA\PathParameter(name="order", example="1"),
     *     @OA\Response(response="200", description="An example endpoint"),
     *     @OA\Response(response="400", description="Something is Wrong"),
     * )
     */
    public function report(Order $order): JsonResponse
    {
         $response = $this->reportDelayService->reportDelay($order);
         return response()->json([
                'message' => $response['message']
            ], $response['status']);
    }
}
