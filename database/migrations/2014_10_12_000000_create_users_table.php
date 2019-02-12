<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (Schema::hasTable('users')) {
         return;
     }
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id', 10);
            $table->string('name', 64);
            $table->string('email', 64)->unique();
            $table->timestamp('email_verified_at', 64)->nullable();
            $table->string('password', 64);
            $table->string('username', 64)->unique();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
