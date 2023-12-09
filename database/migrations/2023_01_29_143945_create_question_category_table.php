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
        Schema::create('question_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisationId')->nullable();
            $table->unsignedBigInteger('userId')->nullable();
            $table->unsignedBigInteger('programId')->nullable();
            $table->unsignedBigInteger('subjectId')->nullable();
            $table->unsignedBigInteger('stateId')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status');
            $table->integer('sortOrder');
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
        Schema::dropIfExists('question_category');
    }
};
