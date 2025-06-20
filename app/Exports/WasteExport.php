<?php

namespace App\Exports;

use App\Models\WasteData;
use Maatwebsite\Excel\Concerns\FromCollection;

class WasteExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WasteData::all();
    }
}
