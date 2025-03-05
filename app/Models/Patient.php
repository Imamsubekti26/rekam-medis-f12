<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['member_id', 'name', 'phone', 'address', 'is_male', 'date_of_birth', 'food_allergies', 'drug_allergies'];

    public function medical_records()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}
