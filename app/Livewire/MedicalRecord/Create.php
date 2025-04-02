<?php

namespace App\Livewire\MedicalRecord;

use App\Models\MedicalRecord;
use App\Models\Prescription;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{
    public $record;
    public $record_id;
    private $prescriptions;

    #[On('submitPatientToParent')]
    public function collectPatient($patient_id, $printing = false)
    {
        $this->record['patient_id'] = $patient_id;
        $this->saveHandler();
        
        if ($printing) {
            $this->dispatch('printRecord', $this->record_id);
        }
    }

    #[On('submitRecordToParent')]
    public function collectRecord($record)
    {
        $this->record = $record;
    }

    #[On('submitPrescriptionToParent')]
    public function collectPrescription($prescriptions, $deletedPrescriptions)
    {
        $this->prescriptions = $prescriptions;
    }

    public function storeData()
    {
        $this->dispatch('collectRecord');
        $this->dispatch('collectPrescriptions');
        $this->dispatch('collectPatient');
    }

    public function storeAndPrint()
    {
        $this->dispatch('collectRecord');
        $this->dispatch('collectPrescriptions');
        $this->dispatch('collectPatient', printing: true);
    }

    public function saveHandler()
    {
        try {
            DB::beginTransaction();
            $newMedical = new MedicalRecord($this->record);
            $newMedical->save();

            $this->record_id = $newMedical->id;
            
            Prescription::bulkInsert($newMedical->id, $this->prescriptions);
            DB::commit();

            $this->redirectRoute('patient.show', $newMedical->patient_id);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            session()->flash('errors',__('medical_record.create_failed'));
        }
    }

    public function render()
    {
        return view('livewire.medical-record.create');
    }
}
