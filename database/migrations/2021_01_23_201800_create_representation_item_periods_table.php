<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentationItemPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representation_item_periods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('representation_id');
            $table->foreign('representation_id')->references('id')
            ->on('representations')->onDelete('cascade');
            $table->unsignedBigInteger('item_period_id');
            $table->foreign('item_period_id')->references('id')
            ->on('item_periods')->onDelete('cascade');
            $table->unsignedInteger('seniorRepresentationProfit');
            $table->unsignedInteger('normalRepresentationProfit');
            $table->unsignedInteger('userProfit');
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
        Schema::dropIfExists('representation_item_periods');
    }
}
