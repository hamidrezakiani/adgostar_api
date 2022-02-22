<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecuterCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('executer_checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('executer_id');
            $table->foreign('executer_id')->references('id')
            ->on('executers')->onDelete('cascade');
            $table->bigInteger('amount');
            $table->enum('status',['IN_PROCESS','CANCELED','COMPLETE']);
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
        Schema::dropIfExists('executer_order_payments');
    }
}
