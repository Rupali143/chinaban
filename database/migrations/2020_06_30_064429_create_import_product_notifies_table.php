<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportProductNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_product_notifies', function (Blueprint $table) {
            $table->Increments('id');
            $table->Integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->json('notify_user_id');
            // $table->foreign('notify_user_id')->references('id')->on('users');
            $table->text('message');
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
