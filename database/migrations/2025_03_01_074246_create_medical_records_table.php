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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('record_number')->unique();
            $table->timestamp('date');
            $table->foreignUuid('patient_id')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('doctor_id')->nullable()->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->decimal('weight',5,2)->nullable();
            $table->integer('temperature')->nullable();
            $table->string('blood_pressure', 7)->nullable();
            $table->longText('anamnesis');
            $table->longText('diagnosis')->nullable();
            $table->longText('therapy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
