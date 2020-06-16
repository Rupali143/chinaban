<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     @author Rupali <rupali.satpute@neosofttech.com>
     @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('en_name',50);
            $table->unsignedInteger('parent_category')->nullable();
            $table->foreign('parent_category')->references('id')->on('categories')  ;
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
        Schema::dropIfExists('categories');
    }
}
