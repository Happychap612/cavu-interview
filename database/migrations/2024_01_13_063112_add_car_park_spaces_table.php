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
        Schema::create('car_park_spaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_park_id')->constrained();
            $table->string('name')->max(10)->default('Space');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_park_spaces');
    }
};
