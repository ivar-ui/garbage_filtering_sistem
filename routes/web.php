<?php

use App\Http\Controllers\WasteDataController;

Route::get('/', [WasteDataController::class, 'index']);
Route::post('/waste_data', [WasteDataController::class, 'store']);

