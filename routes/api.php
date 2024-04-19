<?php

use App\Http\Controllers\AgentsController;
use App\Http\Controllers\DelayReportController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;


Route::post('order/{order}/report-delay',[DelayReportController::class,'report'])->name('order.report-delay');
Route::get('agents/{agent}/get-report',[AgentsController::class,'getReport'])->name('agents.agent.get-report');
Route::get('vendors/get-delayed-orders-report',[VendorController::class,'getDelayedOrdersReport'])->name('vendors.get-delayed-orders-report');
