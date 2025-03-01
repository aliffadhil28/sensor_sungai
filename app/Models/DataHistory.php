<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataHistory extends Model
{
    protected $fillable = ['status','start_time', 'end_time'];
}
