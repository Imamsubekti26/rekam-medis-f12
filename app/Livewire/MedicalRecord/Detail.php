<?php

namespace App\Livewire\MedicalRecord;

use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Detail extends Component
{
    public $record;
    public $prescriptions;
    private $deletedPrescriptions;

    #[On('submitPatientToParent')]
    public function collectPatient($patient_id)
    {
        $this->record['patient_id'] = $patient_id;
        $this->updateHandler();
    }

    #[On('submitRecordToParent')]
    public function collectRecord($record)
    {
        $record['id'] = $this->record['id'];
        $record['record_number'] = $this->record['record_number'];
        $this->record = $record;
    }

    #[On('submitPrescriptionToParent')]
    public function collectPrescription($prescriptions, $deletedPrescriptions)
    {
        $this->prescriptions = $prescriptions;
        $this->deletedPrescriptions = $deletedPrescriptions;
    }

    public function updateData()
    {
        $this->dispatch('collectRecord');
        $this->dispatch('collectPrescriptions');
        $this->dispatch('collectPatient');
    }

    public function updateHandler()
    {
        try {
            DB::beginTransaction();
            MedicalRecord::where('id', $this->record['id'])->update($this->record);

            $medicineStock = ['increment' => array_column($this->deletedPrescriptions, 'medicine_id'), 'decrement' => []];
            
            // update resep yang berubah
            foreach ($this->prescriptions as $prescription) {
                if (isset($prescription['updated']) && $prescription['updated'] == true) {
                    Prescription::updateOrCreate([
                        'id'=> $prescription['id']
                    ],[
                        'medicine_id'=> $prescription['medicine_id'],
                        'rule_of_use'=> $prescription['rule_of_use'],
                        'aftermeal'=> $prescription['aftermeal'],
                        'notes'=> $prescription['notes'],
                        'medical_record_id' => $this->record['id'],
                    ]);
                    array_push($medicineStock['decrement'], $prescription['medicine_id']);
                }
            }

            // delete resep yang dihapus
            Prescription::whereIn('id', array_column( $this->deletedPrescriptions, 'id'))->delete();

            // update stok obat
            $duplicates = array_intersect($medicineStock['increment'], $medicineStock['decrement']);
            if (!empty($duplicates)) {
                $medicineStock['increment'] = array_diff($medicineStock['increment'], $duplicates);
                $medicineStock['decrement'] = array_diff($medicineStock['decrement'], $duplicates);
            }
            if ($medicineStock['increment'] != []) {
                Medicine::whereIn('id', $medicineStock['increment'])->increment('stock');
            }
            if ($medicineStock['decrement'] != []) {
                Medicine::whereIn('id', $medicineStock['decrement'])->decrement('stock');
            }

            DB::commit();

            session()->flash('success',__('medical_record.update_success'));
            return redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            session()->flash('errors',__('medical_record.update_failed'));
        }
    }

    public function mount(MedicalRecord $record)
    {
        $this->record = $record;
        $this->prescriptions = $record->prescriptions;
    }

    public function render()
    {
        return view('livewire.medical-record.detail');
    }
}
