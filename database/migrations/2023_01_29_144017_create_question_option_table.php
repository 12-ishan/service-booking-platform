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
        Schema::create('question_option', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisationId')->nullable();
            $table->unsignedBigInteger('questionId')->nullable();
            $table->text('option')->nullable();
            $table->tinyInteger('isCorrect')->nullable();
            $table->tinyInteger('status');
            $table->integer('sortOrder');
            $table->timestamps();
            $table->foreign('questionId')->references('id')->on('question')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_option');
    }
};
