<?php

namespace App\Http\Controllers;

use App\Models\WasteData;
use Illuminate\Http\Request;

class WasteDataController extends Controller
{
    // Halaman utama: Grafik + semua data terbaru
    public function index()
    {
        $wasteData = WasteData::orderBy('created_at', 'desc')->get();
        return view('waste_data.index', compact('wasteData'));
    }

    // Halaman detail: Semua data dalam tabel
    public function detail()
    {
        $wasteData = WasteData::orderBy('created_at', 'desc')->get();
        return view('waste_data.detail', compact('wasteData'));
    }

    // Halaman riwayat: Semua data untuk log sensor
    public function riwayat()
    {
        $wasteData = WasteData::orderBy('created_at', 'desc')->get();
        return view('waste_data.riwayat', compact('wasteData'));
    }

    // Endpoint simpan data baru dari sensor (Arduino/ESP)
    public function store(Request $request)
    {
        $data = new WasteData();
        $data->jenis = $request->input('jenis');
        $data->kelembapan = $request->input('kelembapan');
        $data->save();

        return response()->json(['success' => true]);
    }

    // Endpoint untuk AJAX polling: ambil data terbaru (real-time)
    public function getLatest()
    {
        $latestData = WasteData::orderBy('created_at', 'desc')->take(20)->get();
        return response()->json($latestData);
    }
}
