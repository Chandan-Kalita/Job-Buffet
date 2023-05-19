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
        Schema::create('client_master', function (Blueprint $table) {
            $table->bigIncrements('client_id');
            $table->string('name', 100);
            $table->string('phone', 12);
            $table->string('email', 50);
            $table->text('address');
            $table->string('latitude', 15)->nullable();
            $table->string('longitude', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_master');
    }
};
