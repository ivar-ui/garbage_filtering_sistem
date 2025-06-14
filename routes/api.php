<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/waste_data', function (Illuminate\Http\Request $request) {
    \App\Models\WasteData::create([
        'jenis' => $request->jenis,
        'kelembapan' => $request->kelembapan
    ]);
    return response()->json(['message' => 'Data saved']);
});
