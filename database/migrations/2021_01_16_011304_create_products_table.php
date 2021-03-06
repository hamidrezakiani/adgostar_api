<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')
            ->on('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('label');
            $table->string('turkish_name');
            $table->string('turkish_label');
            $table->enum('viewable',['YES','NO'])->default('NO');
            $table->unsignedInteger('tab_index')->nullable();
            $table->enum('periodType',['SINGLE','MULTIPLE'])->default('SINGLE');
            $table->unsignedInteger('count_item')->default(0);
            $table->unsignedInteger('count_property')->default(0);
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
        Schema::dropIfExists('products');
    }
}
