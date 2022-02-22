<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('propertyType',['ORDER','PANEL','WALLET']);
            $table->unsignedBigInteger('property_id');
            $table->string('host')->nullable();
            $table->string('ip')->nullable();
            $table->unsignedBigInteger('amount');
            $table->enum('bank',['IDPAY'])->default('IDPAY');
            $table->enum('status',['PAYING','INITIAL_CANCELLATION','FAILED_PAYMENT','SUCCESS_PAYMENT'])->default('PAYING');
            $table->integer('status_code')->default(0);
            $table->string('payment_id')->nullable();
            $table->string('card_number')->nullable();
            $table->string('hashed_card_number')->nullable();
            $table->unsignedBigInteger('date');
            $table->unsignedBigInteger('track_id')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
