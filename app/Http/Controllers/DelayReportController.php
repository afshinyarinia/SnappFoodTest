<?php

namespace App\Http\Controllers;

use App\Http\Requests\DelayReportRequest;
use App\Models\Order;
use App\Services\ReportDelayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DelayReportController extends Controller
{
    private ReportDelayService $reportDelayService;

    public function __construct()
    {
        $this->reportDelayService = new ReportDelayService();
    }

    public function report(Order $order): JsonResponse
    {
         $response = $this->reportDelayService->reportDelay($order);
         return response()->json([
                'message' => $response['message']
            ], $response['status']);
    }
}
