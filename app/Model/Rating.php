<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
     protected $table = 'ratings';

    public $fillable = ['user_id','rated_user_id','product_id','rate'];
}
