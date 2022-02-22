<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')
            ->on('representations')->onDelete('cascade');
            $table->string('title',255);
            $table->string('logo');
            $table->string('backgroundLogin');
            $table->decimal('balance',20,0)->default(0);
            $table->decimal('removable',20,0)->default(0);
            $table->string('domain')->nullable();
            $table->enum('status',['UNPAID','PAID','COMPLETED','PENDING','ACTIVE','SUSPENDED'])->default('UNPAID');
            $table->enum('kind',['NORMAL','SPECIAL']);
            $table->string('api_token', 80)
            ->unique()->nullable()->default(null);
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
        Schema::dropIfExists('representations');
    }
}
