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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('medicine_id')->nullable()->references('id')->on('medicines')->onUpdate('cascade')->onDelete('set null');
            $table->foreignUuid('medical_record_id')->references('id')->on('medical_records')->onUpdate('cascade')->onDelete('cascade');
            $table->string('rule_of_use')->default('');
            $table->boolean('aftermeal')->default(true);
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
