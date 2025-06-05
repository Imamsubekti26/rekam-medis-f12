<?php

namespace App\Livewire\MedicalRecord;

use App\Models\Patient;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class CardPatient extends Component
{
    public ?string $patient_id;
    public ?Patient $patient_data;
    public string $nik = '';
    public Collection|array $suggestions = [];

    #[On('collectPatient')]
    public function sendPatientToParent($printing = false)
    {
        $this->dispatch('submitPatientToParent', patient_id: $this->patient_id, printing: $printing);
    }

    public function mount($patient = null)
    {
        if ($patient != null) {
            $this->patient_id = $patient->id;
            $this->nik = $patient->nik;
            $this->patient_data = $patient;
            return;
        }

        if (request()->has('patient_id') && request()->patient_id != null) {
            $this->patient_id = request()->patient_id;
            $this->patient_data = Patient::find($this->patient_id);
            $this->nik = $this->patient_data->nik;
        }
    }

    public function findPatientById()
    {
        if (trim($this->nik) === '') {
            $this->patient_data = null;
            $this->patient_id = null;
            $this->suggestions = [];
            return;
        }

        // Live search mode - suggestions
        $this->suggestions = Patient::where('nik', 'like', '%' . $this->nik . '%')
            ->limit(5)
            ->get();

        // Jika hanya satu hasil dan ingin langsung pilih
        if ($this->suggestions->count() === 1) {
            $this->patient_data = $this->suggestions->first();
            $this->patient_id = $this->patient_data->id;
            $this->suggestions = [];
        }
    }

    // Triggered ketika user klik salah satu saran
    public function setPatient($id)
    {
        $this->patient_data = Patient::find($id);
        if ($this->patient_data) {
            $this->patient_id = $this->patient_data->id;
            $this->nik = $this->patient_data->nik;
        }
        $this->suggestions = [];
    }

    public function render()
    {
        return view('livewire.medical-record.card-patient');
    }
}
