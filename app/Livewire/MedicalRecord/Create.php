<?php

namespace App\Livewire\MedicalRecord;

use App\Models\MedicalRecord;
use Livewire\Component;

class Create extends Component
{
    public $record;

    protected $listeners = [
        'sendPatientToParent' => 'collectPatient',
        'sendRecordToParent' => 'collectRecord',
        'sendPrescriptionToParent' => 'collectPrescription',
    ];

    public function collectPatient($patient_id)
    {
        $this->record['patient_id'] = $patient_id;
        $this->saveHandler();
    }

    public function collectRecord($record)
    {
        $this->record = $record;
    }

    public function collectPrescription($prescriptions)
    {
        $this->record['prescriptions'] = $prescriptions;
    }

    public function storeData()
    {
        $this->dispatch('getRecordData');
        $this->dispatch('getPrescriptionData');
        $this->dispatch('getPatientData');
    }

    public function saveHandler()
    {
        $newMedical = new MedicalRecord($this->record);
        $newMedical->save();

        if ($newMedical) {
            $this->redirectRoute('patient.show', $newMedical->patient_id);
        } else {
            session()->flash('errors',__('medical_record.create_failed'));
        }
    }

    public function render()
    {
        return view('livewire.medical-record.create');
    }
}
