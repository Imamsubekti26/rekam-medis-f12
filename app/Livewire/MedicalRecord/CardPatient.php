<?php

namespace App\Livewire\MedicalRecord;

use App\Models\Patient;
use Livewire\Attributes\On;
use Livewire\Component;

class CardPatient extends Component
{
    public ?string $patient_id;
    public ?Patient $patient_data;
    public string $member_id = '';

    #[On('collectPatient')]
    public function sendPatientToParent()
    {
        $this->dispatch('submitPatientToParent', $this->patient_id);
    }

    public function mount($patient = null)
    {
        if ($patient != null) {
            $this->patient_id = $patient->id;
            $this->member_id = $patient->member_id;
            $this->patient_data = $patient;
            return;
        }

        if (request()->has('patient_id') && request()->patient_id != null) {
            $this->patient_id = request()->patient_id;
            $this->patient_data = Patient::find($this->patient_id);
            $this->member_id = $this->patient_data->member_id;
        }
    }

    public function findPatientById()
    {
        if ($this->member_id == '') return;

        $this->patient_data = Patient::where('member_id', $this->member_id)->first();
        if ($this->patient_data != null) {
            $this->patient_id = $this->patient_data->id;
        } else {
            $this->member_id = '';
        }
    }

    public function render()
    {
        return view('livewire.medical-record.card-patient');
    }
}
