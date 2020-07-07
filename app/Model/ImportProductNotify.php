<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ImportProductNotify extends Model
{
    protected $casts = [
        'notify_user_id' => 'array'
    ];
}
