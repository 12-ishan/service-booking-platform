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
        Schema::create('meeting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('programId')->nullable();
            $table->unsignedBigInteger('subjectId')->nullable();
            $table->unsignedBigInteger('topicId')->nullable();
            // $table->unsignedBigInteger('stateId')->nullable();
            $table->unsignedBigInteger('organisationId')->nullable();
            $table->tinyInteger('hour')->default('1');
            $table->date('date')->nullable();
            $table->unsignedBigInteger('timeSlotId')->nullable();
            $table->unsignedBigInteger('sessionRecieverId')->nullable();
             $table->unsignedBigInteger('addBy')->nullable();
            $table->unsignedBigInteger('tutorId')->nullable();
            $table->unsignedBigInteger('orderId')->nullable();
            $table->string('meetingUrl')->nullable();
            $table->tinyInteger('meetingStatus')->default('0');
            $table->tinyInteger('scheduleStatus')->default('0');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('imageId')->nullable();
            $table->string('pdfId')->nullable();
            $table->string('practiceSetQuestionId')->nullable();
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
        Schema::dropIfExists('meeting');
    }
};
