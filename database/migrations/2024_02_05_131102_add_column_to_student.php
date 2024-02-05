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
        Schema::table('student', function (Blueprint $table) {
            //
            $table->tinyInteger('receive_updates')->after('password');
            $table->tinyInteger('is_otp_verified')->after('receive_updates');
            $table->string('otp')->nullable()->after('is_otp_verified');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student', function (Blueprint $table) {
            //
            $table->dropColumn(['receive_updates', 'is_otp_verified', 'otp']);
        });
    }
};
