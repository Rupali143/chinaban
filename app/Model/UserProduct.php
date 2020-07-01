<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    protected $table = 'user_product';

    protected $fillable = ['id','category_id','product_id','is_import'];
}
