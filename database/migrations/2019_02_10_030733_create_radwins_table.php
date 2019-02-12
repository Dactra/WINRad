<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadwinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radwins', function (Blueprint $table) {
          $table->increments('id');
          $table->string('username', 64)->default('radius');
          $table->string('password', 64)->default('radius');
          $table->string('radwinserial');
          $table->enum('radwinservicecategory', [1,2,3,4,5,6,7,8])->default(1);
          $table->string('radwinname', 64)->default('Name');
          $table->string('radwinlocation', 64)->default('Location');
          $table->integer('radwinvlan')->default(null)->nullable();
          $table->boolean('radwinregisteravailability')->default(true);
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
        Schema::dropIfExists('radwins');
    }
}
