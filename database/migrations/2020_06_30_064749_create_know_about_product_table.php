<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowAboutProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('know_about_product', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('en_name',100);
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
        Schema::dropIfExists('know_about_products');
    }
}
