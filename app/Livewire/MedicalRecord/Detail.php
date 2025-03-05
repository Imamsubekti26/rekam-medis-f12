<?php

namespace App\Livewire\MedicalRecord;

use App\Models\MedicalRecord;
use Livewire\Component;

class Detail extends Component
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
        $this->updateHandler();
    }

    public function collectRecord($record)
    {
        $record['id'] = $this->record['id'];
        $record['record_number'] = $this->record['record_number'];
        $this->record = $record;
    }

    public function collectPrescription($prescriptions)
    {
        $this->record['prescriptions'] = $prescriptions;
    }

    public function updateData()
    {
        $this->dispatch('getRecordData');
        $this->dispatch('getPrescriptionData');
        $this->dispatch('getPatientData');
    }

    public function updateHandler()
    {
        $medical = MedicalRecord::where('id', $this->record['id'])->update($this->record);

        if ($medical) {
            session()->flash('success',__('medical_record.update_success'));
            $this->redirectRoute('record.index');
        } else {
            session()->flash('errors',__('medical_record.create_failed'));
        }
    }

    public function mount(MedicalRecord $record)
    {
        $this->record = $record;
    }

    public function render()
    {
        return view('livewire.medical-record.detail');
    }
}
