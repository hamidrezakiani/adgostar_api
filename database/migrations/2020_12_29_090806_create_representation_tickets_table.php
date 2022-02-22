<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentationTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representation_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('representation_id');
            $table->foreign('representation_id')->references('id')
            ->on('representations')->onDelete('cascade');
            $table->string('title');
            $table->enum('priority',['LOW','MIDDLE','HIGHT'])->default('MIDDLE');
            $table->enum('status',['PENDING','ANSWERED','CLOSE']);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')
            ->on('representations')->onDelete('cascade');
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
        Schema::dropIfExists('representation_tickets');
    }
}
