<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTicketMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_ticket_id');
            $table->foreign('user_ticket_id')->references('id')
            ->on('user_tickets')->onDelete('cascade');
            $table->unsignedBigInteger('representation_id')->nullable();
            $table->foreign('representation_id')->references('id')
            ->on('representations')->onDelete('cascade');
            $table->string('text');
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
        Schema::dropIfExists('user_ticket_messages');
    }
}
