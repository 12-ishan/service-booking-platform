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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roleId')->nullable();
            $table->unsignedBigInteger('parentId')->nullable();
            $table->unsignedBigInteger('organisationId')->nullable();
            //$table->string('username')->nullable();
            $table->string('name')->nullable();
            $table->string('imageId')->nullable();
            $table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('password');
           // $table->rememberToken();
           $table->tinyInteger('status');
           $table->integer('sortOrder');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
