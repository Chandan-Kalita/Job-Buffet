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
        Schema::create('job_master', function (Blueprint $table) {
            $table->bigIncrements('job_id');
            $table->bigInteger('agency_id');
            $table->string('name', 255);
            $table->text('address');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('latitude', 15);
            $table->string('longitude', 15);
            $table->bigInteger('accepted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_master');
    }
};
