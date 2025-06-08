<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'schedule_id',
        'phone',
        'date',
        'time',
        'detail',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(){
        return $this->belongsTo(User::class);
    }

    public function schedule(){
        return $this->belongsTo(DoctorSchedule::class, 'schedule_id');
    }
}
