<?php

namespace App\Http\Controllers;

use App\Http\Resources\VendorDelayedOrdersReport;
use App\Models\DelayedOrder;
use App\Models\DelayReport;
use App\Models\Vendor;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

class VendorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/vendors/get-delayed-orders-report",
     *     summary="Get A Report Of Vendors With Most Delays",
     *     tags={"Vendors"},
     *     @OA\Response(response="200", description="An example endpoint"),
     * )
     */
    public function getDelayedOrdersReport(): AnonymousResourceCollection
    {
        // get all the delayed orders
        $vendors =  Vendor::has('delays')->withCount(['delays as total_delay_time' => function ($query) {
            $query->select(DB::raw('SUM(time)'));
        }])
            ->orderBy('total_delay_time','desc')
            ->paginate(10);
        return VendorDelayedOrdersReport::collection($vendors);
    }
}
