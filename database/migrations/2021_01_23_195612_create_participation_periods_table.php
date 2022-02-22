<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipationPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participation_periods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participation_id');
            $table->foreign('participation_id')->references('id')
            ->on('participations')->onDelete('cascade');
            $table->unsignedBigInteger('start')->nullable();
            $table->unsignedBigInteger('end')->nullable();
            $table->unsignedBigInteger('cost');
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
        Schema::dropIfExists('participation_periods');
    }
}
