<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['record_number', 'date', 'patient_id', 'doctor_id', 'weight', 'temperature', 'blood_pressure', 'anamnesis', 'diagnosis', 'therapy', 'prescriptions'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(){
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->record_number = self::generateRecordNumber();
        });
    }

    private static function generateRecordNumber()
    {
        $date = now()->format('ymd');
        $prefix = "RM-$date.";

        $count = self::where('record_number', 'LIKE', "$prefix%")->count() + 1; // TODO: ambil count dari data terakhir hari ini bukan jml kolom table

        $number = str_pad($count, 4, '0', STR_PAD_LEFT);

        return "$prefix$number";
    }
}
