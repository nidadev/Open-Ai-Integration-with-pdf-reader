<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_vectors', function (Blueprint $table) {
            $table->id();
            $table->json('vector');
            $table->unsignedBigInteger('file_id');
            $table->unsignedBigInteger('text_id');
            $table->foreign('text_id')->references('id')->on('text_data');
            $table->foreign('file_id')->references('id')->on('file_uploads');
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
        Schema::dropIfExists('text_vectors');
    }
};
