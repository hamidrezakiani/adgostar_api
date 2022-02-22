<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('representation_id');
            $table->foreign('representation_id')->references('id')
            ->on('representations')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('logo')->nullable();
            $table->string('backgroundLogin')->nullable();
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
        Schema::dropIfExists('representation_public_details');
    }
}
