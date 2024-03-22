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
        Schema::create('applicant_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id')->nullable();
            $table->string('pd_first_name')->nullable();
            $table->string('pd_last_name')->nullable();
            $table->string('pd_email')->nullable();
            $table->bigInteger('pd_mobile_number')->nullable();
            $table->date('pd_dob')->nullable();
            $table->string('pd_profile_id')->nullable();
            $table->unsignedBigInteger('pd_gender_id')->nullable();
            $table->unsignedBigInteger('pd_bg_id')->nullable();
            $table->dateTime('pd_cdate_time')->nullable();
            $table->string('ca_house_number')->nullable();
            $table->unsignedBigInteger('ca_city')->nullable();
            $table->unsignedBigInteger('ca_state_id')->nullable();
            $table->string('ca_pincode')->nullable();
            $table->boolean('is_permanent_address')->default(1)->nullable();
            $table->string('pe_house_number')->nullable();
            $table->unsignedBigInteger('pe_city')->nullable();
            $table->unsignedBigInteger('pe_state_id')->nullable();
            $table->string('pe_pincode')->nullable();
            $table->tinyInteger('status');
            $table->integer('sort_order');
            $table->timestamps();
            $table->foreign('application_id')->references('id')->on('application')->onDelete('cascade');
            $table->foreign('pd_gender_id')->references('id')->on('gender')->onDelete('cascade');
            $table->foreign('pd_bg_id')->references('id')->on('blood_group')->onDelete('cascade');
            $table->foreign('ca_city')->references('id')->on('city')->onDelete('cascade');
            $table->foreign('ca_state_id')->references('id')->on('state')->onDelete('cascade');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_details');
    }
};
