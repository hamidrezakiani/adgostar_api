<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')
            ->on('orders')->onDelete('cascade');
            $table->enum('sender',['USER','REPRESENTATION']);
            $table->unsignedBigInteger('time');
            $table->enum('status',['PENDING','REJECT','ACCEPT'])->default('PENDING');
            $table->unsignedInteger('group_counter');
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
        Schema::dropIfExists('order_times');
    }
}
