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
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_rm')->unique();
            $table->string('nik', 16)->unique();
            $table->string('name', 50);
            $table->string('phone', 24)->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_male')->default(true);
            $table->timestamp('date_of_birth')->nullable();
            $table->string('food_allergies')->nullable();
            $table->string('drug_allergies')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
