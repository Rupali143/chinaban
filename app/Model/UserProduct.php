<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    protected $table = 'user_product';

    protected $fillable = ['id','user_id','category_id','product_id','is_import'];

    // public function category(){
    // 	return $this->belogsToMany(Category::class);
    // }

    public function category() {   
    	return $this->belongsTo(Category::class,'category_id');
    }

    //user_product have many users.fetched users with foreign_key user_id
    public function users() {   
    	return $this->belongsTo(User::class,'user_id');
    }

    //user_product have many products.fetched products with foreign_key product_id
    public function products(){
        return $this->belongsTo(Product::class,'product_id');
    }

}
