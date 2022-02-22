<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')
            ->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('property_type_id');
            $table->foreign('property_type_id')->references('id')
            ->on('property_types')->onDelete('cascade');
            $table->string('label')->nullable();
            $table->integer('size')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('tooltip')->nullable();
            $table->enum('required',['YES','NO'])->default('NO');
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
        Schema::dropIfExists('properties');
    }
}
