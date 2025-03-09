<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory, HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['name', 'description', 'stock', 'price', 'barcode'];

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
