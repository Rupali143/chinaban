<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('mobile_number')->length('10');
            $table->string('name',100);
            $table->string('email',50)->unique();
            $table->date('dob');
            $table->tinyInteger('is_manufacture');
            $table->rememberToken();
            $table->tinyInteger('is_profile_complete')->default('0');
            $table->dateTime('created_at');	
            $table->dateTime('updated_at');
            $table->softDeletes();	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_users');
    }
}
