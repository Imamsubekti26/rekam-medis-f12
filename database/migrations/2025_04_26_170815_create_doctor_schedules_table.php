<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('doctor_id')->constrained('users')->onDelete('cascade');
            $table->date('available_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('per_patient_time')->default(20)->comment('In minutes'); // contoh: 15, 30
            $table->enum('serial_visibility', ['Sequential', 'Random'])->default('Sequential');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};

