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
        Schema::table('application', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('program_id')->nullable()->after('student_id');
            $table->foreign('program_id')->references('id')->on('program')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application', function (Blueprint $table) {
            //
            $table->dropColumn('program_id');
        });
    }
};
