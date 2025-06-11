<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'no_rm',        // jangan lupa ditambahin supaya bisa diisi mass assignment
        'nik',
        'name',
        'phone',
        'address',
        'is_male',
        'date_of_birth',
        'food_allergies',
        'drug_allergies'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            if (empty($patient->no_rm)) {
                $datePart = now()->format('ymd'); // yymmdd

                // Ambil pasien terakhir berdasarkan nomor RM secara global (tanpa filter tanggal)
                $lastPatient = Patient::where('no_rm', 'like', 'RM-%')
                    ->orderBy('no_rm', 'desc')
                    ->first();

                if ($lastPatient) {
                    // Ambil 4 digit terakhir setelah titik (misalnya: RM-250609.0042 → 0042)
                    $lastNumber = (int) substr($lastPatient->no_rm, -4);
                    $newNumber = $lastNumber + 1;
                } else {
                    $newNumber = 1;
                }

                $patient->no_rm = sprintf('RM-%s.%04d', $datePart, $newNumber);
            }
        });
    }



    public function medical_records()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
