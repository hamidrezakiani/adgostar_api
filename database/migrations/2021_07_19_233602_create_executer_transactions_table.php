<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecuterTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('executer_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('executer_id');
            $table->foreign('executer_id')->references('id')
            ->on('executers')->onDelete('cascade');
            $table->decimal('amount',20,0)->default(0);
            $table->enum('type',['INCREASE','DECREASE']);
            $table->enum('property',['CHECKOUT','ORDER']);
            $table->unsignedBigInteger('property_id');
            $table->enum('status',['DOING','DONE']);
            $table->decimal('balance', 20, 0)->default(0);
            $table->decimal('removable', 20, 0)->default(0);
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
        Schema::dropIfExists('executer_transactions');
    }
}
