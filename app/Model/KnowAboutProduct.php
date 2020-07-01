<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KnowAboutProduct extends Model
{
    protected $table = 'know_about_product';

    protected $fillable = ['en_name'];
}
