<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['record_number', 'date', 'patient_id', 'doctor_id', 'weight', 'temperature', 'blood_pressure', 'anamnesis', 'diagnosis', 'therapy'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(){
        return $this->belongsTo(User::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
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

        $lastData = self::where('record_number', 'LIKE', "$prefix%")->orderBy("created_at","desc")->first();
        
        if ($lastData) {
            $lastNumber = (int) substr($lastData->record_number, strlen($prefix));
            $incremented = $lastNumber + 1;
        } else {
            $incremented = 1;
        }

        $number = str_pad($incremented, 4, '0', STR_PAD_LEFT);

        return "$prefix$number";
    }
}
