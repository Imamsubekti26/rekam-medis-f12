<?php

namespace App\Livewire\MedicalRecord;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class CardRecord extends Component
{
    public $doctor_id = "";
    public $doctor_name = "";
    public $doctor_list = [];
    public ?int $temperature;
    public ?int $weight;
    public ?string $blood_pressure;
    public ?string $anamnesis;
    public ?string $diagnosis;
    public ?string $therapy;
    public ?string $checkup_date;

    #[On('collectRecord')]
    public function sendRecordToParent()
    {
        $this->dispatch('submitRecordToParent', [
            "date" => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
            "doctor_id" => $this->doctor_id,
            "weight" => $this->weight ?? 0,
            "temperature" => $this->temperature ?? 0,
            "blood_pressure" => $this->blood_pressure ?? null,
            "anamnesis" => $this->anamnesis ?? null,
            "diagnosis" => $this->diagnosis ?? null,
            "therapy" => $this->therapy ?? null,
        ]);
    }

    public function mount($record = null)
    {
        if ($record != null) {
            $this->doctor_id = $record->doctor->id;
            $this->doctor_name = $record->doctor->name;
            $this->temperature = $record->temperature;
            $this->weight = $record->weight;
            $this->blood_pressure = $record->blood_pressure;
            $this->anamnesis = $record->anamnesis;
            $this->diagnosis = $record->diagnosis;
            $this->therapy = $record->therapy;
            $this->checkup_date = Carbon::parse($record->date)->format('Y-m-d');
            return;
        }

        if (request()->user()->is_admin) {
            $this->doctor_list = User::where('role', 'doctor')->get();
            return;
        }

        $doctor = request()->user();
        $this->doctor_id = $doctor->id;
        $this->doctor_name = $doctor->name;

        $this->checkup_date = Carbon::today()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.medical-record.card-record');
    }
}
