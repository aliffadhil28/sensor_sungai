<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberTelegram extends Model
{
    protected $fillable = ['chat_id', 'username'];
}
