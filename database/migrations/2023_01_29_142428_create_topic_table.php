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
        Schema::create('topic', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('programId')->nullable();
            $table->unsignedBigInteger('subjectId')->nullable();
            $table->unsignedBigInteger('organisationId')->nullable();
            $table->text('title')->nullable();
            $table->tinyInteger('status');
            $table->integer('sortOrder');
            $table->timestamps();
            $table->foreign('subjectId')->references('id')->on('subject')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topic');
    }
};
