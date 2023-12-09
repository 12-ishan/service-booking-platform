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
        Schema::create('question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisationId')->nullable();
            $table->unsignedBigInteger('userId')->nullable();
            $table->unsignedBigInteger('questionCategoryId')->nullable();
            $table->text('question')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->integer('marks')->nullable();
            $table->string('imageId')->nullable();
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
        Schema::dropIfExists('question');
    }
};
