<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public $fillable = ['user_id','commented_user_id','product_id','comment'];

}
