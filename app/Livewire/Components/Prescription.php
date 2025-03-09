<?php

namespace App\Livewire\Components;

use App\Models\Medicine;
use Livewire\Attributes\On;
use Livewire\Component;

class Prescription extends Component
{
    public $key;
    public $medicine_id;
    public $medicine_name;
    public $rule_of_use;
    public $aftermeal;
    public $notes;
    public $in_edit;
    public $prescriptions;

    public function lockPrescription()
    {
        $this->in_edit = false;
        
        $prescription = [
            'id' => $this->key,
            'medicine_id' => $this->medicine_id,
            'rule_of_use' => $this->rule_of_use,
            'aftermeal'=> $this->aftermeal,
            'notes' => $this->notes,
            'in_edit' => false,
            'updated' => true,
        ];

        $this->dispatch('lockPrescription', $prescription);
    }

    public function unlockPrescription()
    {
        $this->in_edit = true;
    }

    public function removePrescription()
    {
        $this->dispatch('removePrescription', $this->key);
    }

    #[On('dropdownOnSearch')]
    public function getDataOnSearch($search_key)
    {
        $this->prescriptions = Medicine::select('id', 'name as item')->where("name","like","%". $search_key ."%")->get();
        $this->dispatch('dataObtained', $this->prescriptions);
    }

    #[On('dropdownOnSelected')]
    public function medicineSelected($id, $name)
    {
        $this->medicine_id = $id;
        $this->medicine_name = $name;
    }

    public function mount($data)
    {
        $this->key = $data['id'];
        $this->rule_of_use = $data['rule_of_use'];
        $this->aftermeal = $data['aftermeal'] == 1;
        $this->notes = $data['notes'];
        $this->in_edit = $data['in_edit'];
        $this->medicine_id = $data['medicine_id'];
        $this->medicine_name = $data['medicine_name'];
    }

    public function render()
    {
        return view('livewire.components.prescription');
    }
}
