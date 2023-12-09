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
        Schema::create('subject', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('programId')->nullable();
            $table->unsignedBigInteger('organisationId')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status');
            $table->integer('sortOrder');
            $table->timestamps();
            $table->foreign('programId')->references('id')->on('program')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject');
    }
};
