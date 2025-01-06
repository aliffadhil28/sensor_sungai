<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceDataStream extends Model
{
    protected $fillable = [
        'device_id',
        'debit_air',
        'debit_air_status',
        'tinggi_air',
        'tinggi_air_status',
        'curah_hujan',
        'curah_hujan_status',
        'battery'
    ];
}
