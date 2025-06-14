<?php

namespace App\Http\Controllers;

use App\Models\WasteData;
use Illuminate\Http\Request;

class WasteDataController extends Controller
{
    public function index()
    {
        $wasteData = WasteData::orderBy('created_at', 'desc')->get();
        return view('waste_data.index', compact('wasteData'));
    }

    public function store(Request $request)
    {
        $data = new WasteData();
        $data->jenis = $request->input('jenis');
        $data->kelembapan = $request->input('kelembapan');
        $data->save();

        return response()->json(['success' => true]);
    }
}
