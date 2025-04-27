<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan oleh model ini (jika berbeda dengan nama model)
    protected $table = 'appointments';

    // Tentukan kolom yang dapat diisi secara massal
    // protected $fillable = [
    //     'doctor_name',
    //     'patient_name',
    //     'appointment_date',
    //     'start_time',
    //     'end_time',
    // ];

    // // Tentukan tipe data untuk kolom tertentu (opsional)
    // protected $casts = [
    //     'appointment_date' => 'date',
    //     'start_time' => 'time',
    //     'end_time' => 'time',
    // ];
}
