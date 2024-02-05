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
        Schema::create('payment_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisation_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->string('transaction_number')->nullable();
            $table->tinyInteger('payment_status');
            $table->integer('sort_order');
            $table->timestamps();
            $table->foreign('organisation_id')->references('id')->on('organisation')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('student')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('program')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_history');
    }
};
