<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->Increments('id');
            $table->Integer('user_id');
            $table->Integer('rated_user_id');
            $table->Integer('product_id');
            $table->float('rate');
            $table->dateTime('created_at'); 
            $table->dateTime('updated_at');
            $table->softDeletes()->nullable(1);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
