<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteData extends Model
{
    protected $table = 'waste_data';

    protected $fillable = ['jenis', 'kelembapan'];

    // Karena tidak ada kolom `updated_at`
    public $timestamps = false;

    // Gunakan created_at saja
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;
}
