<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceData extends Model
{
    protected $fillable = [
        'device_id',
        'tanggal',
        'waktu',
        'debit_air',
        'tinggi_air',
        'curah_hujan',
        'battery'
    ];
}
