<?php

use App\Http\Controllers\DelayReportController;
use Illuminate\Support\Facades\Route;


Route::post('order/{order}/report-delay',[DelayReportController::class,'report'])->name('order.report-delay');
