<?php

namespace App\Http\Controllers;

use App\Exports\WasteExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export()
    {
        return Excel::download(new WasteExport, 'data_sampah.xlsx');
    }
}

