<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')
            ->on('items')->onDelete('cascade');
            $table->unsignedBigInteger('representation_id');
            $table->foreign('representation_id')->references('id')
            ->on('representations')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
            ->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('executer_id');
            $table->foreign('executer_id')->references('id')
            ->on('executers')->onDelete('cascade');
            $table->string('product_name');
            $table->string('item_name');
            $table->unsignedBigInteger('unit_price');
            $table->unsignedBigInteger('count');
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('wallet_payment')->default(0);
            $table->unsignedBigInteger('bank_payment')->default(0);
            $table->enum('status',['INITIAL_CANCELLATION','FAILED_PAYMENT',
            'SUCCESS_PAYMENT','COMPLETE','CLOSED','SECONDARY_CANCELLATION']);
            $table->unsignedBigInteger('startTime');
            $table->enum('time_status',['FIRST_REQUEST','USER_REQUEST','REPRESENTATION_REQUEST','CONFIRMED'])->default('FIRST_REQUEST');
            $table->unsignedBigInteger('endTime');
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
        Schema::dropIfExists('orders');
    }
}
