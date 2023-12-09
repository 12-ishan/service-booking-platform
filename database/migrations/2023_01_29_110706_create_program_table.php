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
        Schema::create('program', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisationId')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('metaKeyword')->nullable();
            $table->text('metaDescription')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('program');
    }
};
