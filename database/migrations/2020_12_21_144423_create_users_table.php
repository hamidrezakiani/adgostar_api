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
            $table->id();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->boolean('verify')->default(0);
            $table->string('avatar')->nullable();
            $table->string('api_token', 80)
            ->unique()->nullable()->default(null);
            $table->rememberToken();
            $table->unsignedBigInteger('representation_id');
            $table->foreign('representation_id')->references('id')
            ->on('representations')->onDelete('cascade');
            $table->enum('role',['USER','OWNER'])->default('USER');
            $table->enum('status',['ACTIVE','SUSPENDED'])->default('ACTIVE');
            $table->decimal('wallet',20,0)->default(0);
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
        Schema::dropIfExists('users');
    }
}
