<?php

namespace App\Livewire\MedicalRecord;

use Livewire\Component;

class CardPrescription extends Component
{
    public $prescriptions = [];
    protected $listeners = ['getPrescriptionData' => 'sendPrescriptionToParent'];

    public function sendPrescriptionToParent()
    {
        $this->dispatch('sendPrescriptionToParent', json_encode($this->prescriptions));
    }

    public function addNewPrescription()
    {
        $this->prescriptions = [[
            'medicine_name' => '',
            'schedule' => '',
            'aftermeal'=> true,
            'notes' => '',
            'locked' => false,
        ], ...$this->prescriptions];
    }

    public function lockPrescription(int $index)
    {
        $this->prescriptions[$index]['locked'] = true;
    }

    public function unlockPrescription(int $index)
    {
        $this->prescriptions[$index]['locked'] = false;
    }

    public function removePrescription(int $index)
    {
        unset($this->prescriptions[$index]);
        $this->prescriptions = array_values($this->prescriptions);
    }

    public function mount($prescriptions = null)
    {
        if ($prescriptions != null) {
            $this->prescriptions = json_decode($prescriptions, true);
        }
    }

    public function render()
    {
        return view('livewire.medical-record.card-prescription');
    }
}
