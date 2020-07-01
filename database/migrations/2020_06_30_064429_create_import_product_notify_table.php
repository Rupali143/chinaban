<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportProductNotifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_product_notify', function (Blueprint $table) {
            $table->Increments('id');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            // $table->json('notify_user_id')->unsigned();
            // $table->foreign('notify_user_id')->references('id')->on('users');
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
        Schema::dropIfExists('import_product_notifies');
    }
}
