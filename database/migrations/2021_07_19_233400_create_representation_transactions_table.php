<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentationTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representation_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('representation_id');
            $table->foreign('representation_id')->references('id')
            ->on('representations')->onDelete('cascade');
            $table->decimal('amount', 20, 0)->default(0);
            $table->enum('type', ['INCREASE', 'DECREASE']);
            $table->enum('property', ['CHECKOUT', 'ORDER','SUBSET_ORDER']);
            $table->unsignedBigInteger('property_id');
            $table->enum('status', ['DOING', 'DONE']);
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
        Schema::dropIfExists('representation_transactions');
    }
}
