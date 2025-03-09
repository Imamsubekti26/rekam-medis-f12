<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['id', 'medicine_id', 'medical_record_id', 'rule_of_use', 'aftermeal', 'notes'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function medical_record()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public static function bulkInsert(string $medicalRecordId, array $data)
    {
        $prescriptions = [];
        foreach ($data as $d) {
            $prescription = [
                'id'=> $d['id'],
                'medicine_id'=> $d['medicine_id'],
                'medical_record_id'=> $medicalRecordId,
                'rule_of_use'=> $d['rule_of_use'],
                'aftermeal'=> $d['aftermeal'],
                'notes'=> $d['notes'],
                'created_at'=> now(),
            ];
            array_push($prescriptions, $prescription);
        }
        self::insert($prescriptions);
    }
}
