<?php

namespace App\Livewire\MedicalRecord;

use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class CardPrescription extends Component
{
    public $prescriptions = [];
    public $deletedPrescriptions = [];

    #[On('collectPrescriptions')]
    public function sendPrescriptionToParent()
    {
        $this->dispatch('submitPrescriptionToParent', $this->prescriptions, $this->deletedPrescriptions);
    }

    #[On('lockPrescription')]
    public function syncPrescription($prescription)
    {
        $index = array_search($prescription['id'], array_column($this->prescriptions, 'id'));
        if ($index !== false) {
            $this->prescriptions[$index] = $prescription;
        }
    }

    #[On('removePrescription')]
    public function deletePrescription($id)
    {
        array_push($this->deletedPrescriptions, $id);
        $index = array_search($id, array_column($this->prescriptions, 'id'));
        unset($this->prescriptions[$index]);
        $this->prescriptions = array_values($this->prescriptions);
    }

    public function addNewPrescription()
    {
        $prescription = [
            'id' => Str::uuid()->toString(),
            'medicine_id' => '',
            'medicine_name' => '',
            'rule_of_use' => '',
            'aftermeal'=> true,
            'notes' => '',
            'in_edit' => true,
        ];
        array_unshift($this->prescriptions, $prescription);
    }

    public function mount($prescriptions = null)
    {
        if ($prescriptions != null) {
            $temp = [];
            foreach ($prescriptions as $p) {
                $prescription = [
                    'id' => $p->id,
                    'medicine_id' => $p->medicine_id,
                    'medicine_name' => $p->medicine->name,
                    'rule_of_use' => $p->rule_of_use,
                    'aftermeal'=> $p->aftermeal,
                    'notes' => $p->notes,
                    'in_edit' => false,
                ];
                array_push($temp, $prescription);
            }
            $this->prescriptions = $temp;
        }
    }

    public function render()
    {
        return view('livewire.medical-record.card-prescription');
    }
}
