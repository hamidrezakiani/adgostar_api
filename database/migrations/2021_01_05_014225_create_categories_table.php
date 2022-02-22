<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')
            ->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('showParent_id')->nullable();
            $table->foreign('showParent_id')->references('id')
            ->on('categories')->onDelete('cascade');
            $table->string('code');
            $table->string('name');
            $table->string('label');
            $table->enum('show',['YES','NO'])->default('NO');
            $table->enum('trash',['YES','NO'])->default('NO');
            $table->unsignedInteger('count_product')->default(0);
            $table->unsignedInteger('count_subCat')->default(0);
            $table->unsignedInteger('count_showSubCat')->default(0);
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
        Schema::dropIfExists('categories');
    }
}
