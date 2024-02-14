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
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id')->nullable();
            $table->unsignedBigInteger('highschool_markssheet_id')->nullable();
            $table->unsignedBigInteger('inter_markssheet_id')->nullable();
            $table->unsignedBigInteger('consolidated_marksheet_id')->nullable();
            $table->unsignedBigInteger('consolidated_certificate_id')->nullable();
            $table->unsignedBigInteger('aadhar_card_id')->nullable();
            $table->unsignedBigInteger('signature_id')->nullable();
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
        Schema::dropIfExists('documents');
    }
};
