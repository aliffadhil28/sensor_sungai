<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAttachment extends Model
{
    protected $fillable = [
        'device_id',
        'tanggal',
        'waktu',
        'file',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
