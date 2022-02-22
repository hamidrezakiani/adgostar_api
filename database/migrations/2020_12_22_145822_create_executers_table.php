<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('executers', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('password')->nullable();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->boolean('verify')->default(0);
            $table->string('avatar')->nullable();
            $table->decimal('balance',20,0)->default(0);
            $table->decimal('removable',20,0)->default(0);
            $table->enum('status',['ACTIVE','SUSPENDED']);
            $table->string('api_token',80);
            $table->softDeletes();
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
        Schema::dropIfExists('executers');
    }
}
