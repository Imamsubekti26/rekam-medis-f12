<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // <-- Tambahkan ini

class DoctorSchedule extends Model
{
    use HasFactory, HasUuids; // <-- Tambahkan HasUuids

    protected $keyType = 'string'; // <-- ID akan berupa string (UUID)
    public $incrementing = false;  // <-- Nonaktifkan auto-increment

    protected $fillable = [
        'doctor_id',
        'available_date',
        'start_time',
        'end_time',
        'schedule_type',
        'handle_count',
    ];

    /**
     * Relasi ke tabel users (dokter).
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Relasi ke tabel appointment.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'schedule_id');
    }
}
