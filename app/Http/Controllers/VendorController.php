<?php

namespace App\Http\Controllers;

use App\Http\Resources\VendorDelayedOrdersReport;
use App\Models\DelayedOrder;
use App\Models\DelayReport;
use App\Models\Vendor;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function getDelayedOrdersReport(): AnonymousResourceCollection
    {
        // get all the delayed orders
        $vendors =  Vendor::withCount(['delays as total_delay_time' => function ($query) {
            $query->select(DB::raw('SUM(delay_time)'));
        }])
            ->orderBy('total_delay_time','desc')
            ->get();
        return VendorDelayedOrdersReport::collection($vendors);
    }
}
