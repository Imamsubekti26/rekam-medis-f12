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
        'patient_name',
        'phone',
        'date',
        'time',
        'detail',
        'status',
    ];
}
