<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scholarship', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id')->nullable();
            $table->unsignedBigInteger('merit_based_scholarship')->nullable();
            $table->unsignedBigInteger('explanation_document_id')->nullable();
            $table->tinyInteger('status');
            $table->integer('sort_order');
            $table->timestamps();
            $table->foreign('application_id')->references('id')->on('application')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarship');
    }
};
